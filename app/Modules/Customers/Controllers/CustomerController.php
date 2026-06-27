<?php

namespace App\Modules\Customers\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Customers\Requests\CreateCustomerRequest;
use App\Modules\Customers\Requests\UpdateCustomerRequest;
use App\Modules\Customers\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService,
    ) {}

    public function index(): View
    {
        $customers = $this->customerService->index(auth()->user());

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(CreateCustomerRequest $request): RedirectResponse
    {
        $result = $this->customerService->store(auth()->user(), $request->validated());

        if ($result['status'] === 'limit_reached') {
            return back()->withErrors(['limit' => $result['message']])->withInput();
        }

        if ($result['status'] === 'error') {
            return back()->withErrors(['email' => $result['message']])->withInput();
        }

        return redirect()->route('customers.index')->with('success', 'Customer created.');
    }

    public function show(int $id): View
    {
        $customer = $this->customerService->show(auth()->user(), $id);

        return view('customers.show', compact('customer'));
    }

    public function edit(int $id): View
    {
        $customer = $this->customerService->show(auth()->user(), $id);

        return view('customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, int $id): RedirectResponse
    {
        $result = $this->customerService->update(auth()->user(), $id, $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['email' => $result['message']])->withInput();
        }

        return redirect()->route('customers.show', $id)->with('success', 'Customer updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->customerService->destroy(auth()->user(), $id);

        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
}