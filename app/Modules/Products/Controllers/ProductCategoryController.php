<?php

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Products\Requests\CreateProductCategoryRequest;
use App\Modules\Products\Requests\UpdateProductCategoryRequest;
use App\Modules\Products\Services\ProductCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function __construct(
        protected ProductCategoryService $productCategoryService,
    ) {}

    public function index(): View
    {
        $categories = $this->productCategoryService->index(auth()->user());

        return view('products.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('products.categories.create');
    }

    public function store(CreateProductCategoryRequest $request): RedirectResponse
    {
        $result = $this->productCategoryService->store(auth()->user(), $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['name' => $result['message']])->withInput();
        }

        return redirect()->route('products.categories.index')->with('success', 'Category created.');
    }

    public function edit(int $id): View
    {
        $category = $this->productCategoryService->show(auth()->user(), $id);

        return view('products.categories.edit', compact('category'));
    }

    public function update(UpdateProductCategoryRequest $request, int $id): RedirectResponse
    {
        $result = $this->productCategoryService->update(auth()->user(), $id, $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['name' => $result['message']])->withInput();
        }

        return redirect()->route('products.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->productCategoryService->destroy(auth()->user(), $id);

        return redirect()->route('products.categories.index')->with('success', 'Category deleted.');
    }
}