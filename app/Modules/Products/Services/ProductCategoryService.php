<?php

namespace App\Modules\Products\Services;

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoryService
{
    public function index(User $user): Collection
    {
        return ProductCategory::where('organization_id', $user->organization_id)
            ->orderBy('name')
            ->get();
    }

    public function show(User $user, int $id): ProductCategory
    {
        return ProductCategory::where('organization_id', $user->organization_id)
            ->findOrFail($id);
    }

    public function store(User $user, array $data): array
    {
        $exists = ProductCategory::where('organization_id', $user->organization_id)
            ->where('name', $data['name'])
            ->exists();

        if ($exists) {
            return [
                'status'  => 'error',
                'message' => 'A category with this name already exists.',
            ];
        }

        $category = ProductCategory::create([
            ...$data,
            'organization_id' => $user->organization_id,
        ]);

        return [
            'status'   => 'success',
            'category' => $category,
        ];
    }

    public function update(User $user, int $id, array $data): array
    {
        $category = ProductCategory::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        if (isset($data['name'])) {
            $exists = ProductCategory::where('organization_id', $user->organization_id)
                ->where('name', $data['name'])
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return [
                    'status'  => 'error',
                    'message' => 'A category with this name already exists.',
                ];
            }
        }

        $category->update($data);

        return [
            'status'   => 'success',
            'category' => $category->fresh(),
        ];
    }

    public function destroy(User $user, int $id): void
    {
        ProductCategory::where('organization_id', $user->organization_id)
            ->findOrFail($id)
            ->forceDelete(); // hard delete — SET NULL fires at DB level on products
    }
}