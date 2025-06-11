@extends('layouts.app')
@section('content')
<div class=" bg-gray-900 text-white p-6">
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
                    <td class="p-4">{{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }}</td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($item->horario_disponivel)->format('H:i') }}</td>
                    <td class="p-4">{{ $item->servico->nome_servico }}</td>

                    <td class="p-4">
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button
                                @click="open = {{ $item->status === \App\Enums\StatusAgendamento::Atendido->value ? 'false' : '!open' }}"
                                class="text-xs px-2 py-1 rounded {{ \App\Enums\StatusAgendamento::from($item->status)->badgeClass() }} text-white focus:outline-none"
                                {{ $item->status === \App\Enums\StatusAgendamento::Atendido->value ? 'disabled' : '' }}
                                >
                                {{ \App\Enums\StatusAgendamento::from($item->status)->label() }}
                                @if ($item->status !== \App\Enums\StatusAgendamento::Atendido->value)
                                <svg class="inline-block ml-1 w-3 h-3" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                                @endif
                            </button>

                            @if ($item->status !== \App\Enums\StatusAgendamento::Atendido->value)
                            <div x-show="open" @click.outside="open = false"
                                class="absolute z-10 mt-1 w-40 bg-gray-700 border border-gray-300 rounded shadow-lg">

                                @if ($item->status === \App\Enums\StatusAgendamento::Cancelado->value)
                                {{-- Só permite confirmar --}}
                                <form action="{{ route('agendamento.confirmar', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja confirmar este agendamento?');">
                                    @csrf
                                    <button type="submit" name="status"
                                        value="{{ \App\Enums\StatusAgendamento::Confirmado->value }}"
                                        class="w-full text-left px-3 py-2 hover:bg-gray-600 font-bold text-blue-600">
                                        Confirmar
                                    </button>
                                </form>
                                @elseif ($item->status === \App\Enums\StatusAgendamento::Confirmado->value)
                                {{-- Só permite cancelar --}}
                                <form action="{{ route('agendamento.cancelar', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja cancelar este agendamento?');">
                                    @csrf
                                    <button type="submit" name="status"
                                        value="{{ \App\Enums\StatusAgendamento::Cancelado->value }}"
                                        class="w-full text-left px-3 py-2 hover:bg-gray-600 font-bold text-yellow-600">
                                        Cancelar
                                    </button>
                                </form>
                                @endif
                            </div>
                            @endif
                        </div>
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
