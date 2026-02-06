<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::latest();

        // Scope for Company Admin
        if (auth()->user()->role === 'company') {
            $query->where('company_id', auth()->user()->company_id);
            // Hide SuperAdmins/Admins from Company view if necessary, usually they only want to see their drivers/staff
            // Let's assume they see everyone linked to their company_id
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by Role
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // Filter by Company (Only for SuperAdmin)
        if (auth()->user()->role !== 'company' && $request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        $users = $query->paginate(10)->withQueryString();
        $companies = \App\Models\Company::orderBy('name')->get();

        return view('users.index', compact('users', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = \App\Models\Company::orderBy('name')->get();
        return view('users.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isCompanyAdmin = auth()->user()->role === 'company';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => $isCompanyAdmin ? 'nullable|string' : 'required|string|in:superadmin,admin,driver,company',
            'password' => 'required|string|min:8|confirmed',
            'company_id' => $isCompanyAdmin ? 'nullable' : 'nullable|exists:companies,id',
        ]);

        $role = $validated['role'];
        $companyId = $request->company_id;

        if ($isCompanyAdmin) {
            $role = 'driver'; // Auto-assign driver role for company created users
            $companyId = auth()->user()->company_id;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $role,
            'password' => Hash::make($validated['password']),
            'company_id' => $companyId,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Authorization check for Company Admin
        if (auth()->user()->role === 'company' && $user->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Authorization check for Company Admin
        if (auth()->user()->role === 'company' && $user->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized action.');
        }

        $companies = \App\Models\Company::orderBy('name')->get();
        return view('users.edit', compact('user', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Authorization check for Company Admin
        if (auth()->user()->role === 'company' && $user->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized action.');
        }

        $isCompanyAdmin = auth()->user()->role === 'company';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => $isCompanyAdmin ? 'nullable|string' : 'required|string|in:superadmin,admin,driver,company',
            'password' => 'nullable|string|min:8|confirmed',
            'company_id' => $isCompanyAdmin ? 'nullable' : 'nullable|exists:companies,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!$isCompanyAdmin) {
            $data['role'] = $validated['role'];
            $data['company_id'] = $request->company_id;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        // Authorization check for Company Admin
        if (auth()->user()->role === 'company' && $user->company_id !== auth()->user()->company_id) {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
