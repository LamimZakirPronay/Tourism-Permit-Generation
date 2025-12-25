<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // 1. Validation - Include ALL fields from your military registration form
        $data = $request->validate([
            'ba_no' => 'required|string|unique:users,ba_no',
            'rank' => 'required|string',
            'corps' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'unit' => 'required|string',
            'formation' => 'nullable|string',
            'appointment' => 'required|string',
            'contact_no' => 'nullable|string',
            'blood_group' => 'required|string',
            'date_of_commission' => 'nullable|date',
            'role' => 'required|in:admin,staff',
            'password' => 'required|min:8',
        ]);

        // 2. Hash the password
        $data['password'] = Hash::make($data['password']);

        // 3. Create User (Ensure these fields are in your User Model's $fillable array)
        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Personnel profile initialized successfully!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // 1. Validation - Similar to store, but allow unique email/ba_no for current user
        $data = $request->validate([
            'ba_no' => 'required|string|unique:users,ba_no,'.$user->id,
            'rank' => 'required|string',
            'corps' => 'nullable|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'unit' => 'required|string',
            'formation' => 'nullable|string',
            'appointment' => 'nullable|string',
            'contact_no' => 'nullable|string',
            'blood_group' => 'required|string',
            'date_of_commission' => 'nullable|date',
            'role' => 'required|in:admin,staff',
            'password' => 'nullable|min:8',
        ]);

        // 2. Handle Password update logic
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User profile updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Critical Security Alert: You cannot delete your own Super Admin account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User access revoked and profile deactivated.');
    }

    public function reset2fa(User $user)
    {
        $user->update(['google2fa_secret' => null]);

        return back()->with('success', "Security reset for {$user->name}. 2FA cleared.");
    }
}
