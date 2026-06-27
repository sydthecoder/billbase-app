<?php

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Products\Requests\CreateProductRequest;
use App\Modules\Products\Requests\UpdateProductRequest;
use App\Modules\Products\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
    ) {}

    public function index(): View
    {
        $products = $this->productService->index(auth()->user());

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(CreateProductRequest $request): RedirectResponse
    {
        $result = $this->productService->store(auth()->user(), $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['name' => $result['message']])->withInput();
        }

        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function show(int $id): View
    {
        $product = $this->productService->show(auth()->user(), $id);

        return view('products.show', compact('product'));
    }

    public function edit(int $id): View
    {
        $product = $this->productService->show(auth()->user(), $id);

        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $result = $this->productService->update(auth()->user(), $id, $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['name' => $result['message']])->withInput();
        }

        return redirect()->route('products.show', $id)->with('success', 'Product updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->productService->destroy(auth()->user(), $id);

        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}