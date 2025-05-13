@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-900 text-white p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Inventário</h2>
            <a href="{{ route('admin.inventario.create') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
                + Novo Produto
            </a>
        </div>

        <div class="overflow-x-auto bg-gray-800 rounded shadow">
            <table class="w-full text-left table-auto">
                <thead class="bg-gray-700 text-sm uppercase">
                    <tr>
                        <th class="p-4">Produto</th>
                        <th class="p-4">Categoria</th>
                        <th class="p-4">Quantidade</th>
                        <th class="p-4">Qtd. Mínima</th>
                        <th class="p-4">Última Reposição</th>
                        <th class="p-4">Preço</th>
                        <th class="p-4" colspan="2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventarios as $item)
                        <tr class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="p-4">{{ $item->nome_produto }}</td>
                            <td class="p-4">{{ $item->categoria }}</td>
                            <td class="p-4">{{ $item->quantidade }}</td>
                            <td class="p-4">{{ $item->quantidade_minima }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($item->ultima_reposicao)->format('d/m/Y') }}</td>
                            <td class="p-4">R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                            <td class="p-4 space-x-2">
                                <a href="{{ route('admin.inventario.edit', $item->id) }}"
                                    class="text-yellow-400 hover:underline"><x-heroicon-o-pencil
                                        class="w-5 h-5 text-blue-500" />
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.inventario.destroy', $item->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline"><x-heroicon-o-trash
                                            class="w-5 h-5 text-red-500" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($inventarios->isEmpty())
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-400">Nenhum item encontrado.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endsection