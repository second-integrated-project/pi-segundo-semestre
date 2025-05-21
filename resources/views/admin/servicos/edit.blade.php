@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-900 text-white p-6">
    <h2 class="text-2xl font-bold mb-4">Atualizar Serviço</h2>

    <form action="{{ route('admin.servicos.update', $servico->id) }}" method="POST" class="bg-gray-800 p-6 rounded shadow">
        @csrf
        @method('PATCH')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1">Nome do Serviço</label>
                <input type="text" name="nome_servico" value="{{ $servico->nome_servico }}" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Descrição</label>
                <input type="text" name="descricao" value="{{ $servico->descricao }}" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Valor</label>
                <input type="text" name="valor" value="{{ $servico->valor }}" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Valor Fim de Semana</label>
                <input type="text" name="valor_fim_semana" value="{{ $servico->valor_fim_semana }}" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
           
        </div>
        <div class="flex justify-between">
            <a href="{{ url()->previous() }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                Voltar
            </a>
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Atualizar</button>
        </div>    
    </form>
</div>
@endsection
