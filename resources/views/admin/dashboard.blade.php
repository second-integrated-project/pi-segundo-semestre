@extends('layouts.app')

@section('content')
    <div class="bg-gray-900 text-white">
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Dashboard</h2>

                <!-- Formulário para selecionar data -->
                <form method="GET" action="{{ route('admin.dashboard') }}"
                    class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <label for="data" class="text-sm">Escolha a data:</label>
                    <input type="date" id="data" name="data"
                        value="{{ $dataSelecionada ?? \Carbon\Carbon::today()->toDateString() }}"
                        class="bg-gray-700 text-white rounded px-3 py-1 focus:outline-none">
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded text-white text-sm">Filtrar</button>

                    @php
                        $ontem = \Carbon\Carbon::yesterday()->toDateString();
                        $hoje = \Carbon\Carbon::today()->toDateString();
                        $amanha = \Carbon\Carbon::tomorrow()->toDateString();
                    @endphp

                    <!-- Botões rápidos de data -->
                    <div class="flex gap-2 mt-2 sm:mt-0">
                        <a href="{{ route('admin.dashboard', ['data' => $ontem]) }}"
                            class="px-2 py-1 rounded text-sm 
              {{ $dataSelecionada === $ontem ? 'bg-orange-500 text-white' : 'bg-gray-700 hover:bg-gray-600' }}">
                            Ontem
                        </a>

                        <a href="{{ route('admin.dashboard', ['data' => $hoje]) }}"
                            class="px-2 py-1 rounded text-sm 
              {{ $dataSelecionada === $hoje ? 'bg-orange-500 text-white' : 'bg-gray-700 hover:bg-gray-600' }}">
                            Hoje
                        </a>

                        <a href="{{ route('admin.dashboard', ['data' => $amanha]) }}"
                            class="px-2 py-1 rounded text-sm 
              {{ $dataSelecionada === $amanha ? 'bg-orange-500 text-white' : 'bg-gray-700 hover:bg-gray-600' }}">
                            Amanhã
                        </a>
                    </div>
                </form>
            </div>

            <!-- Cartões de Estatísticas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
                            {{ $texto ? "$texto - " : '' }}{{ $data->format('d/m/Y') }}
                        </span>
                    </div>

                    @forelse ($agendamentosDia as $a)
                        <div class="mb-3 p-3 bg-gray-700 rounded flex justify-between items-center">
                            <div>
                                <p class="font-semibold">{{ $a['cliente'] }}</p>
                                <p class="text-sm text-gray-400">{{ $a['horario'] }} • {{ $a['servico'] }} •
                                    {{ $a['barbeiro'] }}</p>
                            </div>

                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="text-xs px-2 py-1 rounded {{ $a['status_enum']?->badgeClass() ?? 'bg-gray-400' }} text-white focus:outline-none">
                                    {{ $a['status_enum']?->label() ?? 'Indefinido' }}
                                    <svg class="inline-block ml-1 w-3 h-3" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-1 w-36 bg-gray-800 rounded shadow-lg z-10 text-sm">
                                    <form action="{{ route('admin.agendamentos.updateStatus', ['id' => $a['id']]) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $a['id'] }}">
                                        @foreach ($statusOrdenados as $status)
                                            <button type="submit" name="status" value="{{ $status->value }}"
                                                class="w-full text-left px-3 py-2 hover:bg-gray-700 {{ $a['status_enum'] && $a['status_enum']->value === $status->value ? 'font-bold' : '' }}">
                                                {{ $status->label() }}
                                            </button>
                                        @endforeach
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 italic">Nenhum agendamento nesta data.</p>
                    @endforelse
                </div>

                <!-- Desempenho dos Barbeiros -->
                <div class="bg-gray-800 p-4 h-fit rounded shadow sticky top-4 md:col-span-1">
                    <h4 class="text-lg font-semibold mb-4">Desempenho dos Barbeiros</h4>
                    @foreach ($barbeiros as $b)
                        <div class="mb-4">
                            <div class="flex justify-between text-sm">
                                <span><strong>{{ $b['nome'][0] }}</strong> {{ $b['nome'] }}</span>
                                <div class="flex flex-col items-end gap-1">
                                    <span><strong>Confirmado:</strong> {{ $b['valor_confirmado'] }}</span>
                                    <span><strong>Atendido:</strong> {{ $b['valor_atendido'] }}</span>
                                    @if ($b['percent'] >= 100)
                                        <span class="bg-green-600 text-white text-xs px-2 py-0.5 rounded">Meta
                                            atingida</span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-gray-400">{{ $b['agendamentos'] }} agendamentos</p>
                            <div class="w-full bg-gray-700 rounded h-2 mt-1">
                                <div class="bg-orange-500 h-2 rounded" style="width: {{ $b['percent'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <!-- Agendamentos por Barbeiro com toggle -->
            <div class="bg-gray-800 p-4 rounded shadow mt-6" x-data="{ open: false }">
                <div class="flex justify-between items-center mb-4 cursor-pointer select-none" @click="open = !open">
                    <h4 class="text-lg font-semibold">Agendamentos por Barbeiro</h4>
                    <button type="button" class="flex items-center text-sm text-orange-400 focus:outline-none">
                        <span x-text="open ? 'Ocultar' : 'Mostrar'"></span>
                        <svg :class="{ 'transform rotate-180': open }"
                            class="w-4 h-4 ml-1 transition-transform duration-300" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <div x-show="open" x-transition>
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
                                            class="text-xs px-2 py-1 rounded {{ $a['status_enum']?->badgeClass() ?? 'bg-gray-400' }}">
                                            {{ $a['status_enum']?->label() ?? 'Indefinido' }}
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
    </div>

    <!-- Alpine.js e Chart.js -->
    <script src="https://unpkg.com/alpinejs" defer></script>
@endsection
