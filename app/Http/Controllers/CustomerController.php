<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of customers
     */
    public function index()
    {
        $customers = $this->customerService->getAllCustomers();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer (via Ajax)
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        $customer = $this->customerService->createCustomer($data);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Customer created successfully!',
                'customer' => $customer
            ]);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully!');
    }

    /**
     * Show a specific customer
     */
    public function show($id)
    {
        $customer = $this->customerService->getCustomerById($id);
        if (!$customer) {
            abort(404);
        }
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing a customer
     */
    public function edit($id)
    {
        $customer = $this->customerService->getCustomerById($id);
        if (!$customer) {
            abort(404);
        }
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update a customer
     */
    public function update(StoreCustomerRequest $request, $id)
    {
        $data = $request->validated();
        $updated = $this->customerService->updateCustomer($id, $data);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Customer updated successfully!'
            ]);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }


    /**
     * Delete a customer
     */
    public function destroy($id)
    {
        $deleted = $this->customerService->deleteCustomer($id);

        if (request()->ajax()) {
            return response()->json([
                'status' => $deleted ? 'success' : 'error',
                'message' => $deleted ? 'Customer deleted successfully!' : 'Customer not found!'
            ]);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
