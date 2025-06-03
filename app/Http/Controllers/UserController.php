<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        // Alterado para usar a view admin_users.blade.php na raiz de views
        return view('admin_users', compact('users', 'search'));
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
            'role' => 'required|in:USER,ADMIN',
        ]);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'User role updated!');
    }
}