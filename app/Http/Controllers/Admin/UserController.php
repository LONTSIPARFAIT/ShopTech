<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::latest()
                ->get()
                ->map(fn (User $user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'created_at' => $user->created_at,
                    'orders_count' => $user->orders()->count(),
                ]),
        ]);
    }

    public function updateRole(\Illuminate\Http\Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', \Illuminate\Validation\Rule::enum(UserRole::class)],
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Le rôle de l\'utilisateur a été mis à jour.');
    }

    public function destroy(User $user)
    {
        // Protect against self deletion
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return back()->with('success', 'L\'utilisateur a été supprimé avec succès.');
    }
}
