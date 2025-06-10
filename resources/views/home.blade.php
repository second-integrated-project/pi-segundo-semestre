<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="p-4 space-y-6">

        <!-- Logo e Boas-vindas -->
        <div class="text-center">
            <h1 class="text-2xl font-bold mt-2">Bem-vindo à Barbearia {{ config('app.name') }}</h1>
            <p class="text-gray-600">Seu estilo começa aqui!</p>
        </div>

        <!-- Botões principais -->
        <div class="grid grid-cols-1 gap-4">
            <a href="{{ route('agendamento.create') }}" class="odd:bg-black even:bg-gray-800 text-white py-3 rounded-xl text-center shadow">
                Agendar Horário
            </a>
            <a href="{{ route('admin.servicos.index') }}" class="odd:bg-black even:bg-gray-800 text-white py-3 rounded-xl text-center shadow">
                Pacotes de Serviços
            </a>
        </div>
    </div>
@endsection