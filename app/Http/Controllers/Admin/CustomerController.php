<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'CustomerName' => 'required|string|max:255',
            'CustomerEmail' => 'required|email|unique:customers,CustomerEmail',
            'CustomerPhoneNum' => 'required|string',
            'CustomerAddress' => 'required|string',
            'CustomerMembership' => 'nullable|string',
            'AdminID' => 'nullable|integer',
        ]);

        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'CustomerName' => 'required|string|max:255',
            'CustomerEmail' => 'required|email|unique:customers,CustomerEmail,' . $customer->CustomerID . ',CustomerID',
            'CustomerPhoneNum' => 'required|string',
            'CustomerAddress' => 'required|string',
            'CustomerMembership' => 'nullable|string',
            'AdminID' => 'nullable|integer',
        ]);

        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
