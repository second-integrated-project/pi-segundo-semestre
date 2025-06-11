@extends('layouts.app')
@section('content')
<div class=" bg-gray-900 text-white p-6">
    <h2 class="text-2xl font-bold mb-4">Cadastrar Plano</h2>

    <form action="{{ route('admin.pacotes.store') }}" method="POST" class="bg-gray-800 p-6 rounded shadow">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1">Nome do Plano</label>
                <input type="text" name="nome_pacote" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Descrição</label>
                <input type="text" name="descricao" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Valor</label>
                <input type="text" name="valor" required class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
        </div>
        <div class="flex justify-between">
                <a href="{{ url()->previous() }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                    Voltar
                </a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Salvar</button>
        </div>
    </form>
</div>
@endsection