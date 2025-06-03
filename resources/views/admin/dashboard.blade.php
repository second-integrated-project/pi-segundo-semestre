@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 text-white">
    <!-- Conteúdo Principal -->
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Dashboard</h2>
        </div>

        <!-- Cartões de Estatísticas -->        <span><strong>{{ $b['nome'][0] }}</strong> {{ $b['nome'] }}</span>
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
                    <span class="bg-orange-500 text-xs px-2 py-1 rounded">Hoje</span>
                </div>

                @foreach ($agendamentos_dia as $a)
                <div class="mb-3 p-3 bg-gray-700 rounded flex justify-between items-center">
                    <div>
                        <p class="font-semibold">{{ $a['cliente'] }}</p>
                        <p class="text-sm text-gray-400">{{ $a['horario'] }} • {{ $a['servico'] }} • {{ $a['barbeiro']
                            }}
                        </p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded 
    @if($a['status'] == 1) bg-green-500 
    @else bg-yellow-500 @endif">
                        {{ $a['status'] == 1 ? 'Confirmado' : 'Cancelado' }}
                    </span>

                </div>
                @endforeach
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
    </div>
</div>
@endsection