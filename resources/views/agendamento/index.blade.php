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
                        <form
                            action="{{ $item->status == 1 ? route('agendamento.cancelar', $item->id) : route('agendamento.confirmar', $item->id) }}"
                            method="POST" class="inline-block"
                            onsubmit="return confirm('Tem certeza que deseja {{ $item->status == 1 ? 'cancelar' : 'confirmar' }} este agendamento?');">
                            @csrf
                            <label for="toggle_{{$item->id}}" class="inline-flex items-center cursor-pointer">
                                <div class="relative">
                                    <!-- O checkbox será marcado ou desmarcado com base no status -->
                                    <input type="checkbox" id="toggle_{{$item->id}}" name="status" class="sr-only"
                                        onclick="this.form.submit()" {{ $item->status == 1 ? 'checked' : '' }}>
                                    <div class="toggle__line w-12 h-6 bg-gray-300 rounded-full shadow-inner"></div>
                                    <div
                                        class="toggle__dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0 transition">
                                    </div>
                                </div>
                            </label>
                        </form>
                    </td>

                    <style>
                        input[type="checkbox"]:checked+.toggle__line {
                            background-color: #4CAF50;
                            /* Cor verde quando ligado */
                        }

                        input[type="checkbox"]:checked+.toggle__line+.toggle__dot {
                            transform: translateX(100%);
                            /* Mover a bolinha para a direita quando ligado */
                        }

                        .toggle__line {
                            transition: background-color 0.3s ease;
                        }

                        .toggle__dot {
                            transition: transform 0.3s ease;
                        }
                    </style>
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