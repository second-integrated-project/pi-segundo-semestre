@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 text-white p-6">
    @if (auth()->check() && auth()->user()->role === 'admin')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Planos</h2>
        <a href="{{ route('admin.pacotes.create') }}"
            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
            + Novo Plano
        </a>
    </div>
    @endif
    <div class="overflow-x-auto bg-gray-800 rounded shadow">
        <table class="w-full text-left table-auto">
            <thead class="bg-gray-700 text-sm uppercase text-center">
                <tr>
                    <th class="p-4">Plano</th>
                    <th class="p-4">Descrição</th>
                    <th class="p-4">Valor</th>
                    @auth
                    @if(auth()->user()->role === 'user')
                    <th class="p-4">Status</th>
                    <th class="p-4">Ação</th>
                    @elseif(auth()->user()->role === 'admin')
                    <th class="p-4">Editar</th>
                    <th class="p-4">Excluir</th>
                    @endif
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach ($pacotes as $item)
                <tr class="border-b border-gray-700 hover:bg-gray-700 text-center">
                    <td class="p-4">{{ $item->nome_pacote }}</td>
                    <td class="p-4">{{ $item->descricao }}</td>
                    <td class="p-4">R$ {{ number_format($item->valor, 2, ',', '.') }}</td>

                    @auth
                    @if (auth()->user()->role === 'user')
                    <td class="p-4">
                        @if (auth()->user()->pacotes->contains($item->id))
                        <span class="text-green-400 font-semibold">Adquirido</span>
                        @else
                        <span class="text-yellow-400 font-semibold">Disponível</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if (auth()->user()->pacotes->contains($item->id))
                        <form action="{{ route('pacotes.cancelar', $item->id) }}" method="POST"
                            onsubmit="return confirm('Deseja realmente cancelar este plano?');">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">
                                Cancelar
                            </button>
                        </form>
                        @else
                        <form action="{{ route('pacotes.adquirir', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
                                Adquirir
                            </button>
                        </form>
                        @endif
                    </td>
                    @elseif (auth()->user()->role === 'admin')
                    <td class="p-4">
                        <a href="{{ route('admin.pacotes.edit', $item->id) }}"
                            class="text-yellow-400 hover:underline">
                            <x-heroicon-o-pencil class="w-5 h-5 text-blue-500" />
                        </a>
                    </td>
                    <td class="p-4">
                        <form action="{{ route('admin.pacotes.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">
                                <x-heroicon-o-trash class="w-5 h-5 text-red-500" />
                            </button>
                        </form>
                    </td>
                    @endif
                    @endauth
                </tr>
                @endforeach

                @if ($pacotes->isEmpty())
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-400">Nenhum item encontrado.</td>
                </tr>
                @endif
            </tbody>

        </table>
    </div>
</div>
@endsection