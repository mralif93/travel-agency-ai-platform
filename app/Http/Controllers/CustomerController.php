<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('customers')->ignore($customer->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    /**
     * Reset the customer's password to default.
     */
    public function resetPassword(Customer $customer)
    {
        $customer->update([
            'password' => \Illuminate\Support\Facades\Hash::make('P@ssw0rd123'),
        ]);

        return back()->with('success', 'Password has been reset to default: P@ssw0rd123');
    }
}
