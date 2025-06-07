@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-900 text-white p-6">
        @if (auth()->check() && auth()->user()->role === 'admin')
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Serviços</h2>
                <a href="{{ route('admin.servicos.create') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
                    + Novo Serviço
                </a>
            </div>
        @endif

        <div class="overflow-x-auto bg-gray-800 rounded shadow">
            <table class="w-full text-left table-auto">
                <thead class="bg-gray-700 text-sm uppercase text-center">
                    <tr>
                        <th class="p-4">Serviço</th>
                        <th class="p-4">Descrição</th>
                        <th class="p-4">Valor</th>
                        <th class="p-4">Valor Fim de Semana</th>
                        <th class="p-4">Duração em Minutos</th>
                        @if (auth()->check() && auth()->user()->role === 'admin')
                            <th class="p-4">Editar</th>
                            <th class="p-4">Excluir</th>
                        @endif
                    </tr>

                </thead>
                <tbody>
                    @foreach ($servicos as $item)
                        <tr class="border-b border-gray-700 hover:bg-gray-700 text-center">
                            <td class="p-4">{{ $item->nome_servico }}</td>
                            <td class="p-4">{{ $item->descricao }}</td>
                            <td class="p-4">R$ {{ number_format($item->valor, 2, ',', '.') }}</td>
                            <td class="p-4">R$ {{ number_format($item->valor_fim_semana, 2, ',', '.') }}</td>
                            <td class="p-4">{{ $item->duracao_minutos }}</td>
                            @if (auth()->check() && auth()->user()->role === 'admin')
                                <td class="p-4">
                                    <div class="flex items-center justify-center">

                                        <a href="{{ route('admin.servicos.edit', $item->id) }}"
                                            class="text-yellow-400 hover:underline"><x-heroicon-o-pencil
                                                class="w-5 h-5 text-blue-500" />
                                        </a>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('admin.servicos.destroy', $item->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:underline"><x-heroicon-o-trash
                                                class="w-5 h-5 text-red-500" />
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @if ($servicos->isEmpty())
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-400">Nenhum item encontrado.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection