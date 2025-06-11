@extends('layouts.app')

@section('content')
    <div class=" bg-gray-900 text-white p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Gerenciar Usuários</h2>
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex items-center">
                <input type="text" name="search" value="{{ $search }}" placeholder="Digite o nome ou email"
                    class="p-2 rounded text-black">
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Pesquisar</button>
                @if ($search)
                    <a href="{{ route('admin.users.index') }}" class="ml-2 px-4 py-2 bg-orange-500 text-white rounded">
                        Limpar
                    </a>
                @endif
            </form>
        </div>
        <div class="overflow-x-auto bg-gray-800 rounded shadow">
            <table class="w-full text-left table-auto">
                <thead class="bg-gray-700 text-sm uppercase text-center">
                    <tr>
                        <th class="p-4">Nome</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-700 hover:bg-gray-700 text-center">
                            <td class="p-4">{{ $user->name }}</td>
                            <td class="p-4">{{ $user->email }}</td>
                            <td class="p-4">
                                <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()"
                                        class="bg-gray-700 text-white rounded p-1">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>USER</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>ADMIN</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded {{ $user->active ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $user->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-3 py-1 rounded {{ $user->active ? 'bg-yellow-500' : 'bg-green-600' }} text-white">
                                        {{ $user->active ? 'Inativar' : 'Ativar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 my-4 flex justify-center space-x-1 text-sm">
                {{-- Previous Page Link --}}
                @if ($users->onFirstPage())
                    <span class="px-3 py-1 rounded bg-gray-700 text-gray-500 cursor-not-allowed select-none"
                        aria-disabled="true" aria-label="@lang('pagination.previous')">&lsaquo;</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}&search={{ $search }}"
                        class="px-3 py-1 rounded bg-gray-700 text-orange-500 hover:bg-orange-600 hover:text-white"
                        rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($users->links()->elements[0] as $page => $url)
                    @if ($page == $users->currentPage())
                        <span aria-current="page"
                            class="px-3 py-1 rounded bg-orange-600 text-white font-bold cursor-default">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}&search={{ $search }}"
                            class="px-3 py-1 rounded bg-gray-700 text-orange-500 hover:bg-orange-600 hover:text-white">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}&search={{ $search }}"
                        class="px-3 py-1 rounded bg-gray-700 text-orange-500 hover:bg-orange-600 hover:text-white"
                        rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                @else
                    <span class="px-3 py-1 rounded bg-gray-700 text-gray-500 cursor-not-allowed select-none"
                        aria-disabled="true" aria-label="@lang('pagination.next')">&rsaquo;</span>
                @endif
            </div>

        </div>
    </div>
@endsection
