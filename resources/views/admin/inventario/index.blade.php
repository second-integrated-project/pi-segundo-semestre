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
                <thead class="bg-gray-700 text-center uppercase">
                    <tr>
                        <th class="p-4">Produto</th>
                        <th class="p-4">Categoria</th>
                        <th class="p-4">Última Reposição</th>
                        <th class="p-4">Preço</th>
                        <th class="p-4">Quantidade</th>
                        <th class="p-4">Qtd. Mínima</th>
                        <th class="p-4 cursor-pointer"
                            title="Status: Amarelo: 60% da quantidade minima -- Vermelho: 30% da quantidade minima, estado 'critico' -- Verde: boa quantidade.">
                            Status </th>
                        <!-- adicionei esta coluna 'Status' para ficar visivel quando estiver acabando um produto, auxilio de compra -->
                        <th class="p-4">Editar</th>
                        <th class="p-4">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventarios as $item)
                        @php
                            $porcento = $item->quantidade_minima > 0
                                ? ($item->quantidade / $item->quantidade_minima) * 100
                                : 0;
                            $porcento = min($porcento, 100);

                            if ($porcento > 60) {
                                $cor_da_barra = 'bg-green-500';
                            } elseif ($porcento > 30) {
                                $cor_da_barra = 'bg-yellow-500';
                            } else {
                                $cor_da_barra = 'bg-red-500';
                            }
                        @endphp
                        <tr class="border-b border-gray-700 text-center hover:bg-gray-700">
                            <td class="p-4">{{ $item->nome_produto }}</td>
                            <td class="p-4">{{ $item->categoria }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($item->ultima_reposicao)->format('d/m/Y') }}</td>
                            <td class="p-4">R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                            <td class="p-4">{{ $item->quantidade }}</td>
                            <td class="p-4">{{ $item->quantidade_minima }}</td>
                            <td class="p-4">
                                <div class="w-full bg-gray-700 rounded-full h-3">
                                    <div class="h-full {{ $cor_da_barra }} rounded-full transition-all duration-300"
                                        style="width: {{ $porcento }}%"></div>
                                </div>
                                <small class="text-gray-300">{{ round($porcento) }}%</small>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('admin.inventario.edit', $item->id) }}"
                                        class="text-yellow-400 hover:underline">
                                        <x-heroicon-o-pencil class="w-5 h-5 text-blue-500" />
                                    </a>
                                </div>
                            </td>
                            <td class="p-4">
                                <form action="{{ route('admin.inventario.destroy', $item->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline">
                                        <x-heroicon-o-trash class="w-5 h-5 text-red-500" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($inventarios->isEmpty())
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-400">Nenhum item encontrado.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection