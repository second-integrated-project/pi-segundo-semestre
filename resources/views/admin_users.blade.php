@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Gerenciar Usuários</h2>

    <!-- Pesquisa -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex">
        <input type="text" name="search" value="{{ $search }}" placeholder="Pesquisar por nome ou email" class="p-2 rounded text-black">
        <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Pesquisar</button>
    </form>

    @if(session('status'))
        <div class="mb-4 text-green-500">{{ session('status') }}</div>
    @endif

    <table class="min-w-full bg-gray-800 rounded">
        <thead>
            <tr>
                <th class="p-2">Nome</th>
                <th class="p-2">Email</th>
                <th class="p-2">Role</th>
                <th class="p-2">Status</th>
                <th class="p-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b border-gray-700">
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">
                    <form method="POST" action="{{ route('admin.users.role', $user) }}">
                        @csrf
                        @method('PATCH')
                        <select name="role" onchange="this.form.submit()" class="bg-gray-700 text-white rounded p-1">
                            <option value="USER" {{ $user->role == 'USER' ? 'selected' : '' }}>USER</option>
                            <option value="ADMIN" {{ $user->role == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                        </select>
                    </form>
                </td>
                <td class="p-2">
                    <span class="px-2 py-1 rounded {{ $user->active ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $user->active ? 'Ativo' : 'Inativo' }}
                    </span>
                </td>
                <td class="p-2">
                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3 py-1 rounded {{ $user->active ? 'bg-yellow-500' : 'bg-green-600' }} text-white">
                            {{ $user->active ? 'Inativar' : 'Ativar' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection