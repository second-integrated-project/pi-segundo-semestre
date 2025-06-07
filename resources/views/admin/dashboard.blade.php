@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-900 text-white">
        <!-- Conteúdo Principal -->
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Dashboard</h2>

                <!-- Formulário para selecionar data -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <label for="data" class="text-sm">Escolha a data:</label>
                    <input type="date" id="data" name="data"
                        value="{{ $dataSelecionada ?? \Carbon\Carbon::today()->toDateString() }}"
                        class="bg-gray-700 text-white rounded px-3 py-1 focus:outline-none">
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded text-white text-sm">Filtrar</button>
                </form>
            </div>

            <!-- Cartões de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                @foreach ($cards as $card)
                    <div class="bg-gray-800 p-4 rounded shadow">
                        <h3 class="text-sm">{{ $card['title'] }}</h3>
                        <p class="text-2xl font-bold">{{ $card['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Agendamentos e Desempenho -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Próximos Agendamentos -->
                <div class="md:col-span-2 bg-gray-800 p-4 rounded shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold">Próximos Agendamentos</h4>
                        <span class="bg-orange-500 text-xs px-2 py-1 rounded">
                            @php
                                $data = \Carbon\Carbon::parse($dataSelecionada ?? now());
                                $texto = '';

                                if ($data->isToday()) {
                                    $texto = 'HOJE';
                                } elseif ($data->isTomorrow()) {
                                    $texto = 'AMANHÃ';
                                } elseif ($data->isYesterday()) {
                                    $texto = 'ONTEM';
                                }
                            @endphp

                            @if ($texto)
                                {{ $texto }} - {{ $data->format('d/m/Y') }}
                            @else
                                {{ $data->format('d/m/Y') }}
                            @endif

                        </span>
                    </div>

                    @forelse ($agendamentosDia as $a)
                        <div class="mb-3 p-3 bg-gray-700 rounded flex justify-between items-center">
                            <div>
                                <p class="font-semibold">{{ $a['cliente'] }}</p>
                                <p class="text-sm text-gray-400">{{ $a['horario'] }} • {{ $a['servico'] }} •
                                    {{ $a['barbeiro'] }}</p>
                            </div>
                            <span
                                class="text-xs px-2 py-1 rounded
                                @if ($a['status'] == 1) bg-green-500
                                @else bg-yellow-500 @endif">
                                {{ $a['status'] == 1 ? 'Confirmado' : 'Cancelado' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-400 italic">Nenhum agendamento nesta data.</p>
                    @endforelse
                </div>

                <!-- Desempenho dos Barbeiros -->
                <div class="bg-gray-800 p-4 rounded shadow">
                    <h4 class="text-lg font-semibold mb-4">Desempenho dos Barbeiros</h4>
                    @foreach ($barbeiros as $b)
                        <div class="mb-4">
                            <div class="flex justify-between text-sm">
                                <span><strong>{{ $b['nome'][0] }}</strong> {{ $b['nome'] }}</span>
                                <span>{{ $b['valor'] }}</span>
                            </div>
                            <p class="text-xs text-gray-400">{{ $b['agendamentos'] }} agendamentos</p>
                            <div class="w-full bg-gray-700 rounded h-2 mt-1">
                                <div class="bg-orange-500 h-2 rounded" style="width: {{ $b['percent'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Agendamentos por Barbeiro -->
            <div class="bg-gray-800 p-4 rounded shadow mt-6">
                <h4 class="text-lg font-semibold mb-4">Agendamentos por Barbeiro</h4>

                @foreach ($agendamentosPorBarbeiro as $nomeBarbeiro => $agendamentos)
                    <div class="mb-6">
                        <h5 class="text-md font-semibold mb-2 border-b border-gray-700 pb-1">{{ $nomeBarbeiro }}</h5>

                        @if (count($agendamentos) > 0)
                            @foreach ($agendamentos as $a)
                                <div class="mb-2 p-3 bg-gray-700 rounded flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">{{ $a['cliente'] }}</p>
                                        <p class="text-sm text-gray-400">{{ $a['horario'] }} • {{ $a['servico'] }}</p>
                                    </div>
                                    <span
                                        class="text-xs px-2 py-1 rounded
                                        @if ($a['status'] == 1) bg-green-500
                                        @else bg-yellow-500 @endif">
                                        {{ $a['status'] == 1 ? 'Confirmado' : 'Cancelado' }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-400 italic">Nenhum agendamento.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
