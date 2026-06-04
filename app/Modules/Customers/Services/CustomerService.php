<?php

namespace App\Modules\Customers\Services;

use App\Models\Customer;
use App\Models\User;
use App\Services\PlanGate;
use App\Modules\Customers\Resources\CustomerResource;
use App\Services\CodeGeneratorService;
use Illuminate\Http\JsonResponse;

class CustomerService
{
    public function __construct(
        protected PlanGate $planGate = new PlanGate,
    ) {}

    public function index(User $user): JsonResponse
    {
        $customers = Customer::where('organization_id', $user->organization_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => CustomerResource::collection($customers),
        ]);
    }

    public function store(User $user, array $data): JsonResponse
    {
        $currentCount = Customer::where('organization_id', $user->organization_id)->count();
        
        if (! $this->planGate->allows($user, 'customers', $currentCount)) {
            return response()->json([
                'status'  => 'limit_reached',
                'message' => "You've reached the customer limit for the {$this->planGate->getPlanName($user)} plan. Upgrade to add more.",
                'plan'    => $this->planGate->getPlanName($user),
            ], 403);
        }
        
        // Check email unique per org
        $exists = Customer::where('organization_id', $user->organization_id)
            ->where('email', $data['email'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'A customer with this email already exists.',
            ], 422);
        }

        $customer = Customer::create([
            ...$data,
            'organization_id' => $user->organization_id,
            'customer_code'   => CodeGeneratorService::customer($user->organization_id),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Customer created.',
            'data'    => new CustomerResource($customer),
        ], 201);
    }

    public function show(User $user, int $id): JsonResponse
    {
        $customer = Customer::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => new CustomerResource($customer),
        ]);
    }

    public function update(User $user, int $id, array $data): JsonResponse
    {
        $customer = Customer::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        // Check email unique per org excluding current
        if (isset($data['email'])) {
            $exists = Customer::where('organization_id', $user->organization_id)
                ->where('email', $data['email'])
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'A customer with this email already exists.',
                ], 422);
            }
        }

        $customer->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Customer updated.',
            'data'    => new CustomerResource($customer->fresh()),
        ]);
    }

    public function destroy(User $user, int $id): JsonResponse
    {
        $customer = Customer::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        $customer->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Customer deleted.',
        ]);
    }
}