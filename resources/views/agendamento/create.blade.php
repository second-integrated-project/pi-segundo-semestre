@extends('layouts.app')

<script>
    window.barbeiros = @json($barbeiros);
    window.servicos = @json($servicos);
    window.diasSemana = @json($diasSemana);
</script>

@section('content')
    <div class=" bg-gray-900 p-6">
        <h2 class="text-2xl font-bold mb-4 text-white">Realizar Agendamento</h2>

        <form action="{{ route('agendamento.store') }}" method="POST" class="" x-data="agendamento()">
            @csrf
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-lg mx-auto bg-white rounded-lg shadow-sm p-4">

                    <!-- Etapa: Data -->
                    <div x-show="etapa === 'data'">
                        <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <template x-for="dia in diasDisponiveis" :key="dia.value">
                                <button type="button" @click="selecionarData(dia.value)"
                                    :class="dataSelecionado === dia.value ? 'border px-3 py-2 bg-orange-600 text-white' :
                                        'border px-3 py-2 rounded hover:bg-gray-100'">
                                    <span x-text="dia.label"></span>
                                </button>
                            </template>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="button" @click="mudarEtapa('barbeiro')" :disabled="!dataSelecionado"
                                class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                        </div>
                    </div>

                    <!-- Etapa: Barbeiro -->
                    <div x-show="etapa === 'barbeiro'">
                        <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <template x-for="barbeiro in barbeiros" :key="barbeiro.id">
                                <button type="button" @click="selecionarBarbeiro(barbeiro.id, barbeiro.name)"
                                    :class="barbeiroId === barbeiro.id ? 'border px-3 py-2 bg-orange-600 text-white' :
                                        'border px-3 py-2 rounded hover:bg-gray-100'">
                                    <span x-text="barbeiro.name"></span>
                                </button>
                            </template>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <button type="button" @click="mudarEtapa('data')"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Voltar</button>
                            <button type="button" @click="mudarEtapa('servico')" :disabled="!barbeiroId"
                                class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                        </div>
                    </div>

                    <!-- Etapa: Serviço -->
                    <div x-show="etapa === 'servico'">
                        <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <template x-for="servico in servicos" :key="servico.id">
                                <button type="button" @click="selecionarServico(servico.id, servico.nome_servico)"
                                    :class="servicoId === servico.id ? 'border px-3 py-2 bg-orange-600 text-white' :
                                        'border px-3 py-2 rounded hover:bg-gray-100'">
                                    <span x-text="servico.nome_servico"></span>
                                </button>
                            </template>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <button type="button" @click="mudarEtapa('barbeiro')"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Voltar</button>
                            <button type="button" @click="mudarEtapa('horario')" :disabled="!servicoId"
                                class="bg-orange-600 text-white px-4 py-2 rounded disabled:bg-orange-300 disabled:cursor-not-allowed">Próximo</button>
                        </div>
                    </div>

                    <!-- Etapa: Horário -->
                    <div x-show="etapa === 'horario'">
                        <h3 x-text="etapas.find(e => e.id === etapa).nome" class="mb-4"></h3>

                        <template x-if="horariosDisponiveis.length > 0">
                            <div class="text-center">
                                <select x-model="horarioSelecionado" class="border rounded px-3 py-2 w-full max-w-xs">
                                    <option value="" disabled selected>Selecione um horário</option>
                                    <template x-for="hora in horariosDisponiveis" :key="hora">
                                        <option :value="hora" x-text="hora"></option>
                                    </template>
                                </select>
                            </div>
                        </template>

                        <p x-show="horariosDisponiveis.length === 0 && dataSelecionado && barbeiroId && servicoId"
                            class="text-center text-red-600 mt-2">
                            Nenhum horário disponível para essa combinação.
                        </p>

                        <div class="mt-4 flex justify-between">
                            <button type="button" @click="mudarEtapa('servico')"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Voltar</button>
                            <button type="submit" :disabled="!horarioSelecionado"
                                class="bg-green-600 text-white px-4 py-2 rounded disabled:bg-green-300 disabled:cursor-not-allowed">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inputs escondidos para enviar dados ao backend -->
            <input type="hidden" name="data" :value="dataSelecionado" />
            <input type="hidden" name="barbeiro_id" :value="barbeiroId" />
            <input type="hidden" name="servico_id" :value="servicoId" />
            <input type="hidden" name="horario" :value="horarioSelecionado" />
        </form>
    </div>

    <script>
        function agendamento() {
            return {
                etapa: 'data',
                dataSelecionado: null,
                barbeiroId: null,
                servicoId: null,
                barbeiroSelecionado: null,
                servicoSelecionado: null,
                horarioSelecionado: null,
                horariosDisponiveis: [],
                etapas: [{
                        id: 'data',
                        nome: 'Escolher a data'
                    },
                    {
                        id: 'barbeiro',
                        nome: 'Escolher o barbeiro'
                    },
                    {
                        id: 'servico',
                        nome: 'Escolher o serviço'
                    },
                    {
                        id: 'horario',
                        nome: 'Escolher o horário'
                    },
                    {
                        id: 'confirmar',
                        nome: 'Confirmar dados'
                    },
                ],
                barbeiros: window.barbeiros,
                servicos: window.servicos,
                diasDisponiveis: window.diasSemana,

                selecionarData(data) {
                    this.dataSelecionado = data;
                    this.horarioSelecionado = null;
                    this.buscarHorarios();
                },

                selecionarBarbeiro(id, nome) {
                    this.barbeiroId = id;
                    this.barbeiroSelecionado = nome;
                    this.horarioSelecionado = null;
                    this.buscarHorarios();
                },

                selecionarServico(id, nome) {
                    this.servicoId = id;
                    this.servicoSelecionado = nome;
                    this.horarioSelecionado = null;
                    this.buscarHorarios();
                },

                buscarHorarios() {
                    console.log('buscarHorarios chamada', {
                        data: this.dataSelecionado,
                        barbeiro: this.barbeiroId,
                        servico: this.servicoId,
                    });

                    if (!this.dataSelecionado || !this.barbeiroId || !this.servicoId) {
                        this.horariosDisponiveis = [];
                        console.log('faltam dados para buscar horários');
                        return;
                    }

                    console.log('fetch será chamado');

                    fetch(
                            `/agendamento/horarios-disponiveis?data=${this.dataSelecionado}&barbeiro_id=${this.barbeiroId}&servico_id=${this.servicoId}`
                        )
                        .then(res => {
                            console.log('Resposta fetch status:', res.status);
                            return res.json();
                        })
                        .then(data => {
                            console.log('Horários disponíveis:', data);
                            this.horariosDisponiveis = data;
                            this.horarioSelecionado = null;
                        })
                        .catch(error => {
                            console.error('Erro no fetch:', error);
                            this.horariosDisponiveis = [];
                        });
                },

                mudarEtapa(novaEtapa) {
                    this.etapa = novaEtapa;
                    if (novaEtapa !== 'horario') {
                        this.horarioSelecionado = null;
                    }
                }
            }
        }
    </script>
@endsection
