@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-900 text-white p-6">
    <h2 class="text-2xl font-bold mb-4">Realizar Agendamento</h2>

    <form action="{{ route('agendamento.store') }}" method="POST" class="bg-gray-800 p-6 rounded shadow">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1">Data</label>
                <input type="date" name="data" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>

            <div>
                <label class="block mb-1">Barbeiro</label>
                <select name="barbeiro_id" required class="w-full p-2 rounded bg-gray-700 text-white">
                    <option value="">Selecione um barbeiro</option>
                    @foreach($barbeiros as $barbeiro)
                    <option value="{{ $barbeiro->id }}">{{ $barbeiro->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Horário</label>
                <input type="time" name="horario_disponivel" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>

            <div>
                <label class="block mb-1">Serviços</label>
                <select name="servico_id" required class="w-full p-2 rounded bg-gray-700 text-white">
                    <option value="">Selecione um serviço</option>
                    @foreach($servicos as $servico)
                    <option value="{{ $servico->id }}">{{ $servico->nome_servico }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Agendar</button>
    </form>
</div>
@endsection