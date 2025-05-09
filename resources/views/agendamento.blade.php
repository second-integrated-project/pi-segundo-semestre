@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agendamento') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8" x-data="{
                                etapa: 'verificar',
                                clienteCadastrado: false,
                                nome: '',
                                telefone: '',
                                dataNascimento: '',
                                barbeiroSelecionado: null,
                                servicoSelecionado: null,
                                horarioSelecionado: null,
                                etapas: [
                                    { id: 'verificar', nome: 'Verificar cadastro' },
                                    { id: 'barbeiro', nome: 'Escolher o barbeiro' },
                                    { id: 'servico', nome: 'Escolher o serviço' },
                                    { id: 'horario', nome: 'Escolher o horário' },
                                    { id: 'confirmar', nome: 'Confirmar dados' }
                                ],
                                clientesMockados: [
                                    { nome: 'João Silva', telefone: '(11) 98765-4321', dataNascimento: '1990-01-01' },
                                    { nome: 'Maria Souza', telefone: '(11) 91234-5678', dataNascimento: '1985-05-15' }
                                ],

                                verificarCadastro() {
                                    const cliente = this.clientesMockados.find(cliente =>
                                        cliente.telefone.replace(/\D/g, '') === this.telefone.replace(/\D/g, '') &&
                                        cliente.dataNascimento === this.dataNascimento
                                    );

                                    if (cliente) {
                                        this.nome = cliente.nome;
                                        this.clienteCadastrado = true;
                                        this.etapa = 'barbeiro';
                                    } else {
                                        this.clienteCadastrado = false;

                                        if (!this.etapas.find(e => e.id === 'cadastrar')) {
                                            this.etapas.splice(1, 0, { id: 'cadastrar', nome: 'Cadastrar-se' });
                                        }

                                        this.etapa = 'cadastrar';
                                    }
                                },

                                cadastrarCliente() {
                                    const novoCliente = {
                                        nome: this.nome,
                                        telefone: this.telefone,
                                        dataNascimento: this.dataNascimento
                                    };
                                    this.clientesMockados.push(novoCliente);
                                    this.clienteCadastrado = true;
                                    this.etapa = 'barbeiro';
                                    this.etapas = this.etapas.filter(e => e.id !== 'cadastrar');
                                },

                                finalizarAgendamento() {
                                    alert('Agendamento confirmado!');
                                    this.etapa = 'verificar';
                                }
                            }">
        <div class="max-w-lg mx-auto bg-white rounded-lg shadow-sm p-4">

            <!-- Etapa: Verificar -->
            <div x-show="etapa === 'verificar'">
                <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                <div class="space-y-3">
                    <input type="tel" x-model="telefone" id="telefone" placeholder="Celular (WhatsApp)"
                        class="border px-4 py-2 rounded w-full">
                    <input type="date" x-model="dataNascimento" placeholder="Data de Nascimento"
                        class="border px-4 py-2 rounded w-full">
                    <button @click="verificarCadastro"
                        class="bg-orange-600 text-white px-4 py-2 rounded w-full">Continuar</button>
                </div>
            </div>

            <!-- Etapa: Cadastrar -->
            <div x-show="etapa === 'cadastrar'">
                <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                <div class="space-y-3">
                    <input type="text" x-model="nome" placeholder="Nome completo" class="border px-4 py-2 rounded w-full">
                    <input type="tel" x-model="telefone" placeholder="Celular (WhatsApp)"
                        class="border px-4 py-2 rounded w-full">
                    <input type="date" x-model="dataNascimento" placeholder="Data de Nascimento"
                        class="border px-4 py-2 rounded w-full">
                </div>
                <div class="mt-4 flex justify-between">
                    <button @click="etapa = 'verificar'" class="text-gray-500 px-4 py-2">Voltar</button>
                    <button @click="cadastrarCliente" :disabled="!nome || !telefone || !dataNascimento"
                        class="bg-green-600 text-white px-4 py-2 rounded disabled:bg-green-300 disabled:cursor-not-allowed">Cadastrar</button>
                </div>
            </div>

            <!-- Etapa: Barbeiro -->
            <div x-show="etapa === 'barbeiro'">
                <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="barbeiro in ['João Pedro', 'Erisson']" :key="barbeiro">
                        <button @click="barbeiroSelecionado = barbeiro" :class="barbeiroSelecionado === barbeiro ? 'bg-orange-600 text-white' : 'border px-4 py-2 rounded hover:bg-gray-100'">
                            <span x-text="barbeiro"></span>
                        </button>
                    </template>
                </div>
                <div class="mt-4 flex justify-end">
                    <button @click="etapa = 'servico'" :disabled="!barbeiroSelecionado"
                        class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                </div>
            </div>

            <!-- Etapa: Serviço -->
            <div x-show="etapa === 'servico'">
                <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="servico in ['Corte', 'Barba', 'Corte + Barba']" :key="servico">
                        <button @click="servicoSelecionado = servico" :class="servicoSelecionado === servico ? 'bg-orange-600 text-white' : 'border px-4 py-2 rounded hover:bg-gray-100'">
                            <span x-text="servico"></span>
                        </button>
                    </template>
                </div>
                <div class="mt-4 flex justify-between">
                    <button @click="etapa = 'barbeiro'" class="text-gray-500 px-4 py-2">Voltar</button>
                    <button @click="etapa = 'horario'" :disabled="!servicoSelecionado"
                        class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                </div>
            </div>

            <!-- Etapa: Horário -->
            <div x-show="etapa === 'horario'">
                <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <template x-for="hora in ['14:00', '14:45', '15:30']" :key="hora">
                        <button @click="horarioSelecionado = hora" :class="horarioSelecionado === hora ? 'bg-orange-600 text-white' : 'border px-3 py-2 rounded hover:bg-gray-100'">
                            <span x-text="hora"></span>
                        </button>
                    </template>
                </div>
                <div class="mt-4 flex justify-between">
                    <button @click="etapa = 'servico'" class="text-gray-500 px-4 py-2">Voltar</button>
                    <button @click="etapa = 'confirmar'" :disabled="!horarioSelecionado"
                        class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                </div>
            </div>

            <!-- Etapa: Confirmar -->
            <div x-show="etapa === 'confirmar'">
                <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                <div class="space-y-2 text-sm">
                    <p><strong>Nome:</strong> <span x-text="nome"></span></p>
                    <p><strong>Telefone:</strong> <span x-text="telefone"></span></p>
                    <p><strong>Data de Nascimento:</strong> <span x-text="dataNascimento"></span></p>
                    <p><strong>Barbeiro:</strong> <span x-text="barbeiroSelecionado"></span></p>
                    <p><strong>Serviço:</strong> <span x-text="servicoSelecionado"></span></p>
                    <p><strong>Horário:</strong> <span x-text="horarioSelecionado"></span></p>
                </div>
                <div class="mt-4 flex justify-between">
                    <button @click="etapa = 'horario'" class="text-gray-500 px-4 py-2">Voltar</button>
                    <button @click="finalizarAgendamento" class="bg-green-600 text-white px-4 py-2 rounded">Confirmar
                        Agendamento</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const telefoneInput = document.getElementById('telefone');

            IMask(telefoneInput, {
                mask: [{
                    mask: '(00) 0000-0000'
                },
                {
                    mask: '(00) 00000-0000'
                }
                ]
            });
        });

        function verificarCadastro() {
            this.clienteCadastrado = true;
            this.etapa = 3;
        }

        function cadastrarCliente() {
            this.clienteCadastrado = true;
            this.etapa = 3;
        }

        function finalizarAgendamento() {
            // Lógica para finalizar o agendamento
            alert('Agendamento confirmado!');
            this.etapa = 1; // Volta para a etapa inicial (opcional, caso queira reiniciar o processo)
        }
    </script>
@endsection()