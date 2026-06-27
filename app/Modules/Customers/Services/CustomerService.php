<?php

namespace App\Modules\Customers\Services;

use App\Models\Customer;
use App\Models\User;
use App\Services\PlanGate;
use App\Services\CodeGeneratorService;
use Illuminate\Database\Eloquent\Collection;

class CustomerService
{
    public function __construct(
        protected PlanGate $planGate = new PlanGate,
    ) {}

    public function index(User $user): Collection
    {
        return Customer::where('organization_id', $user->organization_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store(User $user, array $data): array
    {
        $currentCount = Customer::where('organization_id', $user->organization_id)->count();

        if (! $this->planGate->allows($user, 'customers', $currentCount)) {
            return [
                'status'  => 'limit_reached',
                'message' => "You've reached the customer limit for the {$this->planGate->getPlanName($user)} plan. Upgrade to add more.",
            ];
        }

        $exists = Customer::where('organization_id', $user->organization_id)
            ->where('email', $data['email'])
            ->exists();

        if ($exists) {
            return [
                'status'  => 'error',
                'message' => 'A customer with this email already exists.',
            ];
        }

        $customer = Customer::create([
            ...$data,
            'organization_id' => $user->organization_id,
            'customer_code'   => CodeGeneratorService::customer($user->organization_id),
        ]);

        return [
            'status'   => 'success',
            'customer' => $customer,
        ];
    }

    public function show(User $user, int $id): Customer
    {
        return Customer::where('organization_id', $user->organization_id)
            ->findOrFail($id);
    }

    public function update(User $user, int $id, array $data): array
    {
        $customer = Customer::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        if (isset($data['email'])) {
            $exists = Customer::where('organization_id', $user->organization_id)
                ->where('email', $data['email'])
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return [
                    'status'  => 'error',
                    'message' => 'A customer with this email already exists.',
                ];
            }
        }

        $customer->update($data);

        return [
            'status'   => 'success',
            'customer' => $customer->fresh(),
        ];
    }

    public function destroy(User $user, int $id): void
    {
        Customer::where('organization_id', $user->organization_id)
            ->findOrFail($id)
            ->delete();
    }
}