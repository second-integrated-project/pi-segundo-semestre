<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Listar e pesquisar usuários
    public function index(Request $request)
{
    $search = $request->input('search');

    $users = User::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
        ->orderBy('name')
        ->paginate(10);

    return view('admin.users.index', compact('users', 'search'));
}

    // Ativar/Inativar usuário
    public function toggleActive(User $user)
    {
        $user->active = !$user->active;
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'User status updated!');
    }

    // Alterar role do usuário
    public function changeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'User role updated!');
    }
}