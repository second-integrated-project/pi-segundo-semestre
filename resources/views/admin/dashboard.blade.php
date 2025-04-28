<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-white text-black p-6">
        <!-- Cartões de Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @php
            $cards = [
                ['title' => 'Agendamentos Hoje', 'value' => 12, 'change' => '+8.5%', 'icon' => 'calendar'],
                ['title' => 'Clientes Atendidos', 'value' => 8, 'change' => '+5.2%', 'icon' => 'users'],
                ['title' => 'Faturamento', 'value' => 'R$ 960,00', 'change' => '+12.3%', 'icon' => 'dollar-sign'],
                ['title' => 'Serviços Realizados', 'value' => 15, 'change' => '-2.5%', 'icon' => 'scissors'],
            ];
            @endphp

            @foreach ($cards as $card)
            <div class="bg-white border p-4 rounded shadow">
                <h3 class="text-sm">{{ $card['title'] }}</h3>
                <p class="text-2xl font-bold">{{ $card['value'] }}</p>
                <p class="{{ str_contains($card['change'], '-') ? 'text-red-500' : 'text-green-500' }}">
                    {{ $card['change'] }} vs. ontem
                </p>
                <div class="mt-2 text-orange-500"><i class="fas fa-{{ $card['icon'] }}"></i></div>
            </div>
            @endforeach
        </div>

        <!-- Agendamentos e Desempenho -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Próximos Agendamentos -->
            <div class="md:col-span-2 bg-white border p-4 rounded shadow">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-lg font-semibold">Próximos Agendamentos</h4>
                    <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">Hoje</span>
                </div>

                @php
                $agendamentos = [
                    ['cliente' => 'João Mendes', 'hora' => '10:30', 'servico' => 'Corte + barba', 'barbeiro' => 'Bruno', 'status' => 'Confirmado'],
                    ['cliente' => 'Carlos Silva', 'hora' => '11:15', 'servico' => 'Corte', 'barbeiro' => 'André', 'status' => 'Pendente'],
                    ['cliente' => 'Marcos Oliveira', 'hora' => '13:00', 'servico' => 'Barba', 'barbeiro' => 'Bruno', 'status' => 'Em Andamento'],
                    ['cliente' => 'Rafael Costa', 'hora' => '14:30', 'servico' => 'Corte + barba + sobrancelha', 'barbeiro' => 'Carlos', 'status' => 'Confirmado'],
                ];
                @endphp

                @foreach ($agendamentos as $a)
                <div class="mb-3 p-3 bg-white border rounded flex justify-between items-center">
                    <div>
                        <p class="font-semibold">{{ $a['cliente'] }}</p>
                        <p class="text-sm text-gray-500">{{ $a['hora'] }} • {{ $a['servico'] }} • {{ $a['barbeiro'] }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded 
                                @if($a['status'] == 'Confirmado') bg-blue-500 text-white
                                @elseif($a['status'] == 'Pendente') bg-yellow-500 text-white
                                @else bg-orange-500 text-white @endif">
                        {{ $a['status'] }}
                    </span>
                </div>
                @endforeach
            </div>

            <!-- Desempenho dos Barbeiros -->
            <div class="bg-white border p-4 rounded shadow">
                <h4 class="text-lg font-semibold mb-4">Desempenho dos Barbeiros</h4>
                @php
                $barbeiros = [
                    ['nome' => 'Bruno', 'valor' => 'R$ 450.00', 'agendamentos' => '6/10', 'percent' => 60],
                    ['nome' => 'André', 'valor' => 'R$ 375.00', 'agendamentos' => '5/8', 'percent' => 63],
                    ['nome' => 'Carlos', 'valor' => 'R$ 320.00', 'agendamentos' => '4/6', 'percent' => 67],
                ];
                @endphp

                @foreach ($barbeiros as $b)
                <div class="mb-4">
                    <div class="flex justify-between text-sm">
                        <span><strong>{{ $b['nome'][0] }}</strong> {{ $b['nome'] }}</span>
                        <span>{{ $b['valor'] }}</span>
                    </div>
                    <p class="text-xs text-gray-500">{{ $b['agendamentos'] }} agendamentos</p>
                    <div class="w-full bg-gray-300 rounded h-2 mt-1">
                        <div class="bg-orange-500 h-2 rounded" style="width: {{ $b['percent'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
