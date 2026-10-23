<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.account.edit', [
            'user' => $request->user(),
            'admins' => User::query()->orderBy('name')->get(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);
        $user->update($data);

        return back()->with('success', 'Profil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(10)->letters()->numbers()],
        ], [
            'current_password.current_password' => 'Password saat ini salah.',
        ]);

        $request->user()->update(['password' => Hash::make($request->input('password'))]);

        return back()->with('success', 'Password berhasil diganti.');
    }

    /** Add another admin account. */
    public function storeAdmin(Request $request)
    {
        $data = $request->validate([
            'new_name' => ['required', 'string', 'max:100'],
            'new_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'new_password' => ['required', Password::min(10)->letters()->numbers()],
        ]);

        User::query()->create([
            'name' => $data['new_name'],
            'email' => $data['new_email'],
            'password' => Hash::make($data['new_password']),
        ]);

        return back()->with('success', 'Admin baru ditambahkan.');
    }

    public function destroyAdmin(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['admin' => 'Tidak bisa menghapus akun yang sedang dipakai.']);
        }
        if (User::query()->count() <= 1) {
            return back()->withErrors(['admin' => 'Minimal harus ada satu admin.']);
        }
        $user->delete();

        return back()->with('success', 'Admin dihapus.');
    }
}
