<?php

namespace App\Modules\Products\Services;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function index(User $user): Collection
    {
        return Product::where('organization_id', $user->organization_id)
            ->with('category')
            ->orderBy('name')
            ->get();
    }

    public function store(User $user, array $data): array
    {
        $exists = Product::where('organization_id', $user->organization_id)
            ->where('name', $data['name'])
            ->exists();

        if ($exists) {
            return [
                'status'  => 'error',
                'message' => 'A product with this name already exists.',
            ];
        }

        $product = Product::create([
            ...$data,
            'organization_id' => $user->organization_id,
        ]);

        return [
            'status'  => 'success',
            'product' => $product->load('category'),
        ];
    }

    public function show(User $user, int $id): Product
    {
        return Product::where('organization_id', $user->organization_id)
            ->with('category')
            ->findOrFail($id);
    }

    public function update(User $user, int $id, array $data): array
    {
        $product = Product::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        if (isset($data['name'])) {
            $exists = Product::where('organization_id', $user->organization_id)
                ->where('name', $data['name'])
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return [
                    'status'  => 'error',
                    'message' => 'A product with this name already exists.',
                ];
            }
        }

        $product->update($data);

        return [
            'status'  => 'success',
            'product' => $product->fresh()->load('category'),
        ];
    }

    public function destroy(User $user, int $id): void
    {
        Product::where('organization_id', $user->organization_id)
            ->findOrFail($id)
            ->delete();
    }
}