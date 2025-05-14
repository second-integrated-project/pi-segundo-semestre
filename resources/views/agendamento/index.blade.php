@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-900 text-white p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Meus Agendamentos</h2>
            <a href="{{ route('agendamento.create') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
                + Novo Agendamento
            </a>
        </div>

        <div class="overflow-x-auto bg-gray-800 rounded shadow">
            <table class="w-full text-left table-auto">
                <thead class="bg-gray-700 text-sm uppercase">
                    <tr>
                        <th class="p-4">Barbeiro</th>
                        <th class="p-4">Data</th>
                        <th class="p-4">Horário</th>
                        <th class="p-4">Serviço</th>
                        <th class="p-4" colspan="2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $item)
                        <tr class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="p-4">{{ $item->barbeiro->name }}</td>
                            <td class="p-4">{{ $item->data }}</td>
                            <td class="p-4">{{ $item->horario_disponivel }}</td>
                            <td class="p-4">{{ $item->servico->nome_servico }}</td>
                         
                            <td class="p-4">
    @if($item->cancelado)
        <span class="text-red-500">Cancelado</span>
    @else
        <form action="{{ route('agendamento.cancelar', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja cancelar este agendamento?');">
            @csrf
            <button type="submit" class="text-yellow-500 hover:underline">
                <x-heroicon-o-x-circle class="w-5 h-5 text-yellow-500" />
                Cancelar
            </button>
        </form>
    @endif
</td>

                        </tr>
                    @endforeach
                    @if ($agendamentos->isEmpty())
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-400">Nenhum item encontrado.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endsection