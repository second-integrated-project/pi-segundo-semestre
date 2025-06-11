@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-sm sm:rounded-lg p-8 md:p-12 text-gray-100">

                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-yellow-400 leading-tight">
                        Bem-vindo à <span class="text-yellow-500">{{ config('app.name') }}</span>
                    </h1>
                    <p class="mt-4 text-xl text-gray-300">
                        Seu estilo começa aqui!
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <a href="{{ route('agendamento.create') }}"
                        class="block bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 rounded-lg shadow text-center text-xl transition duration-300">
                        Agendar Horário
                    </a>

                    <a href="{{ route('admin.servicos.index') }}"
                        class="block bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 rounded-lg shadow text-center text-xl transition duration-300">
                        Pacotes de Serviços
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
