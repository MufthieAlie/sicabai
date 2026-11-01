<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    public function index()
    {
        return Inertia::render('dashboard/users', [
            'users' => User::query()
                ->where('role', 'user')
                ->select('id', 'name', 'email', 'created_at')
                ->latest()
                ->get(),
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless($user->role === 'user', 403);

        $user->delete();

        return back()->with('success', 'Akun user berhasil dihapus.');
    }
}