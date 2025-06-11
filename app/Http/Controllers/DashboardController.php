<?php

namespace App\Http\Controllers;

use App\Enums\StatusAgendamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Agendamento;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dataSelecionada = $request->input('data', Carbon::today()->toDateString());

        // Carregar todos os agendamentos com os relacionamentos necessários
        $todosAgendamentos = Agendamento::with(['cliente', 'servico', 'barbeiro'])
            ->whereDate('data', $dataSelecionada)
            ->get()
            ->map(function ($agendamento) {
                $agendamento->status_enum = StatusAgendamento::tryFrom($agendamento->status);
                return $agendamento;
            });

        $agendamentosConfirmados = $todosAgendamentos->filter(
            fn($ag) => $ag->status_enum === StatusAgendamento::Confirmado
        );

        $agendamentosAtendidos = $todosAgendamentos->filter(
            fn($ag) => $ag->status_enum === StatusAgendamento::Atendido
        );

        // Cartões do topo
        $cards = [
            [
                'title' => 'Agendamentos Confirmados',
                'value' => $agendamentosConfirmados->count(),
            ],
            [
                'title' => 'Clientes Atendidos',
                'value' => $agendamentosAtendidos->unique('cliente_id')->count(),
            ],
            [
                'title' => 'Faturamento Previsto',
                'value' => 'R$ ' . number_format(
                    $agendamentosConfirmados->sum(fn($ag) => $ag->servico->valor ?? 0),
                    2,
                    ',',
                    '.'
                ),
            ],
            [
                'title' => 'Faturamento Total',
                'value' => 'R$ ' . number_format(
                    $agendamentosAtendidos->sum(fn($ag) => $ag->servico->valor ?? 0),
                    2,
                    ',',
                    '.'
                ),
            ]
        ];

        // Lista simples de agendamentos do dia
        $agendamentosDia = $todosAgendamentos->sortBy('horario_disponivel')->map(function ($agendamento) {
            return [
                'id' => $agendamento->id,
                'cliente' => $agendamento->cliente->name ?? 'Não informado',
                'horario' => substr($agendamento->horario_disponivel, 0, 5),
                'servico' => $agendamento->servico->nome_servico ?? 'N/A',
                'barbeiro' => $agendamento->barbeiro->name ?? 'N/A',
                'status_enum' => $agendamento->status_enum,
            ];
        });

        // Desempenho dos barbeiros (admin)

        $barbeiros = User::where('role', 'admin')->get()->map(function ($barbeiro) use ($todosAgendamentos) {
            // Filtra agendamentos do barbeiro para os status Confirmado e Atendido
            $agendamentosConfirmados = $todosAgendamentos->filter(
                fn($ag) =>
                $ag->barbeiro_id === $barbeiro->id && $ag->status === StatusAgendamento::Confirmado->value
            );

            $agendamentosAtendidos = $todosAgendamentos->filter(
                fn($ag) =>
                $ag->barbeiro_id === $barbeiro->id && $ag->status === StatusAgendamento::Atendido->value
            );

            $totalAgendamentos = $agendamentosConfirmados->count() + $agendamentosAtendidos->count();

            $valorConfirmado = $agendamentosConfirmados->sum(fn($ag) => $ag->servico->valor ?? 0);
            $valorAtendido = $agendamentosAtendidos->sum(fn($ag) => $ag->servico->valor ?? 0);

            return [
                'nome' => $barbeiro->name,
                'valor_confirmado' => 'R$ ' . number_format($valorConfirmado, 2, ',', '.'),
                'valor_atendido' => 'R$ ' . number_format($valorAtendido, 2, ',', '.'),
                'agendamentos' => "{$totalAgendamentos}/10",
                'percent' => min($totalAgendamentos * 10, 100),
            ];
        });

        // Agrupamento por barbeiro
        $agendamentosPorBarbeiro = $todosAgendamentos->groupBy(function ($agendamento) {
            return $agendamento->barbeiro->name ?? 'Sem Barbeiro';
        })->map(function ($agendamentos) {
            return $agendamentos->map(function ($agendamento) {
                return [
                    'cliente' => $agendamento->cliente->name ?? 'Não informado',
                    'horario' => substr($agendamento->horario_disponivel, 0, 5),
                    'servico' => $agendamento->servico->nome_servico ?? 'N/A',
                    'status_enum' => $agendamento->status_enum,
                ];
            })->toArray();
        });

        $statusOrdenados = StatusAgendamento::orderedCases();

        return view('admin.dashboard', compact(
            'cards',
            'agendamentosDia',
            'barbeiros',
            'agendamentosPorBarbeiro',
            'dataSelecionada',
            'statusOrdenados'
        ));
    }
}
