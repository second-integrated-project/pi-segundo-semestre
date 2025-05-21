@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-900 black-white p-6">
    <h2 class="text-2xl font-bold mb-4 text-white">Realizar Agendamento</h2>

    <form action="{{ route('agendamento.store') }}" method="POST" class="">
        @csrf
        <div class="py-6 px-4 sm:px-6 lg:px-8" x-data="{
                                etapa: 'data',
                                dataSelecionado: null,
                                barbeiroSelecionado: null,
                                servicoSelecionado: null,
                                horarioSelecionado: null,
                                etapas: [
                                    { id: 'data', nome: 'Escolher a data' },
                                    { id: 'barbeiro', nome: 'Escolher o barbeiro' },
                                    { id: 'servico', nome: 'Escolher o serviço' },
                                    { id: 'horario', nome: 'Escolher o horário' },
                                    { id: 'confirmar', nome: 'Confirmar dados' }
                                ]
                            }">
            <div class="max-w-lg mx-auto bg-white rounded-lg shadow-sm p-4">

                <!-- Etapa: Data -->
                <div x-show="etapa === 'data'">
                    <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <template x-for="hora in ['13/05', '14/05', '15/05']" :key="hora">
                            <button type="button" @click="dataSelecionado = hora" :class="dataSelecionado === hora ? 'bg-orange-600 text-white' : 'border px-3 py-2 rounded hover:bg-gray-100'">
                                <span x-text="hora"></span>
                            </button>
                        </template>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button type="button" @click="etapa = 'barbeiro'" :disabled="!dataSelecionado"
                        class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                    </div>
                </div>
                
                <!-- Etapa: Barbeiro -->
                <div x-show="etapa === 'barbeiro'">
                    <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                    <div class="grid grid-cols-2 gap-3">
                        <template x-for="barbeiro in {{$barbeiros}}" :key="barbeiro.name">
                            <button type="button" @click="barbeiroSelecionado = barbeiro.name" :class="barbeiroSelecionado === barbeiro.name ? 'bg-orange-600 text-white border px-4 py-2 rounded hover:bg-orange-700' : 'border px-4 py-2 rounded hover:bg-gray-100'">
                                <span x-text="barbeiro.name"></span>
                            </button>
                        </template>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" @click="etapa = 'data'" class="text-gray-500 px-4 py-2">Voltar</button>
                        <button type="button" @click="etapa = 'servico'" :disabled="!barbeiroSelecionado"
                        class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                    </div>
                </div>
                
                <!-- Etapa: Serviço -->
                <div x-show="etapa === 'servico'">
                    <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                    <div class="grid grid-cols-2 gap-3">
                        <template x-for="servico in {{$servicos}}" :key="servico">
                            <button type="button" @click="servicoSelecionado = `${servico.nome_servico} R$${servico.valor}`" :class="servicoSelecionado === servico.nome_servico ? 'bg-orange-600 text-white border px-4 py-2 rounded hover:bg-orange-700' : 'border px-4 py-2 rounded hover:bg-gray-100'">
                                <span x-text="servico.nome_servico"></span>
                            </button>
                        </template>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button type="button" @click="etapa = 'barbeiro'" class="text-gray-500 px-4 py-2">Voltar</button>
                        <button type="button" @click="etapa = 'horario'" :disabled="!servicoSelecionado"
                            class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                    </div>
                </div>

                <!-- Etapa: Horário -->
                <div x-show="etapa === 'horario'">
                    <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <template x-for="hora in ['14:00', '14:45', '15:30']" :key="hora">
                            <button type="button" @click="horarioSelecionado = hora" :class="horarioSelecionado === hora ? 'bg-orange-600 text-white' : 'border px-3 py-2 rounded hover:bg-gray-100'">
                                <span x-text="hora"></span>
                            </button>
                        </template>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button type="button" @click="etapa = 'servico'" class="text-gray-500 px-4 py-2">Voltar</button>
                        <button type="button" @click="etapa = 'confirmar'" :disabled="!horarioSelecionado"
                            class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                    </div>
                </div>

                <!-- Etapa: Confirmar -->
                <div x-show="etapa === 'confirmar'">
                    <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Data:</strong> <span x-text="dataSelecionado"></span></p>
                        <p><strong>Barbeiro:</strong> <span x-text="barbeiroSelecionado"></span></p>
                        <p><strong>Serviço:</strong> <span x-text="servicoSelecionado"></span></p>
                        <p><strong>Horário:</strong> <span x-text="horarioSelecionado"></span></p>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button type="button" @click="etapa = 'horario'" class="text-gray-500 px-4 py-2">Voltar</button>
                        <button @click="finalizarAgendamento" class="bg-green-600 text-white px-4 py-2 rounded">Confirmar
                            Agendamento</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection