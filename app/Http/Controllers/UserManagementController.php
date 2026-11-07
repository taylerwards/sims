<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::query()->orderBy('name')->paginate(15);

        return view('users.index', compact('users'));
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $user->forceFill(['password' => $validated['password']])->save();

        return redirect()->route('users.show', $user)->with('status', 'User password updated successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        DB::transaction(function () use ($request, $user): void {
            if ($request->user()->is($user)) {
                throw ValidationException::withMessages([
                    'user' => 'You cannot delete your own account from user management.',
                ]);
            }

            if ($user->role === 'administrator') {
                $administratorCount = User::query()
                    ->where('role', 'administrator')
                    ->lockForUpdate()
                    ->count();

                if ($administratorCount <= 1) {
                    throw ValidationException::withMessages([
                        'user' => 'The last administrator cannot be deleted.',
                    ]);
                }
            }

            $user->delete();
        });

        return redirect()->route('users.index')->with('status', 'User deleted successfully.');
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', Rule::in(['staff', 'administrator'])],
        ]);

        DB::transaction(function () use ($request, $user, $validated): void {
            $currentUser = $request->user();
            $newRole = $validated['role'];

            if ($currentUser->is($user) && $newRole !== 'administrator') {
                throw ValidationException::withMessages([
                    'role' => 'You cannot remove your own administrator role.',
                ]);
            }

            if ($user->role === 'administrator' && $newRole !== 'administrator') {
                $administratorCount = User::query()
                    ->where('role', 'administrator')
                    ->lockForUpdate()
                    ->count();

                if ($administratorCount <= 1) {
                    throw ValidationException::withMessages([
                        'role' => 'The last administrator cannot be changed to Staff.',
                    ]);
                }
            }

            $user->forceFill(['role' => $newRole])->save();
        });

        return redirect()->route('users.index')->with('status', 'User role updated successfully.');
    }
}
