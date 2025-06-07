<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Servico;
use App\Models\User;
use App\Models\Agendamento;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dataSelecionada = $request->input('data', Carbon::today()->toDateString());

        // Agendamentos confirmados do dia
        $agendamentosHoje = Agendamento::whereDate('data', $dataSelecionada)
            ->where('status', 1)
            ->with('servico')
            ->get();

        $agendamentosCount = $agendamentosHoje->count();

        // Clientes atendidos: filtrar só agendamentos confirmados
        $clientesAtendidosCount = Agendamento::whereDate('data', $dataSelecionada)
            ->where('status', 1)
            ->distinct('cliente_id')
            ->count('cliente_id');

        // Faturamento total: já está filtrado por $agendamentosHoje que é só confirmados
        $faturamentoTotal = $agendamentosHoje->sum(function ($agendamento) {
            return $agendamento->servico->valor ?? 0;
        });

        // Serviços realizados: filtrar só confirmados
        $servicosRealizadosCount = Agendamento::whereDate('data', $dataSelecionada)
            ->where('status', 1)
            ->distinct('servico_id')
            ->count('servico_id');

        $cards = [
            ['title' => 'Agendamentos Hoje', 'value' => $agendamentosCount],
            ['title' => 'Clientes Atendidos', 'value' => $clientesAtendidosCount],
            ['title' => 'Faturamento', 'value' => 'R$ ' . number_format($faturamentoTotal, 2, ',', '.')],
            ['title' => 'Serviços Realizados', 'value' => $servicosRealizadosCount],
        ];

        // Agendamentos do dia detalhados (podem mostrar até os cancelados, aí depende do que deseja)
        $agendamentosDia = Agendamento::whereDate('data', $dataSelecionada)
            ->with(['barbeiro', 'servico', 'cliente'])
            ->orderBy('horario_disponivel')
            ->get()
            ->map(function ($agendamento) {
                return [
                    'cliente' => $agendamento->cliente->name ?? 'Não informado',
                    'horario' => substr($agendamento->horario_disponivel, 0, 5),
                    'servico' => $agendamento->servico->nome_servico ?? 'N/A',
                    'barbeiro' => $agendamento->barbeiro->name ?? 'N/A',
                    'status' => $agendamento->status ?? 0,
                ];
            });

        // Desempenho dos barbeiros: filtra só agendamentos confirmados (status=1)
        $barbeiros = User::where('role', 'admin')
            ->get()
            ->map(function ($barbeiro) use ($dataSelecionada) {
                $agendamentos = $barbeiro->agendamentos()
                    ->whereDate('data', $dataSelecionada)
                    ->where('status', 1)
                    ->get();

                $total = $agendamentos->count();
                $valor = $agendamentos->sum(function ($ag) {
                    return $ag->servico->valor ?? 0;
                });

                return [
                    'nome' => $barbeiro->name,
                    'valor' => 'R$ ' . number_format($valor, 2, ',', '.'),
                    'agendamentos' => "$total/10",
                    'percent' => min($total * 10, 100),
                ];
            });

        // Agendamentos agrupados por barbeiro (pode exibir todos, confirmados ou não)
        $agendamentosPorBarbeiro = Agendamento::whereDate('data', $dataSelecionada)
            ->with(['barbeiro', 'cliente', 'servico'])
            ->get()
            ->groupBy(function ($agendamento) {
                return $agendamento->barbeiro->name ?? 'Sem Barbeiro';
            })
            ->map(function ($agendamentos) {
                return $agendamentos->map(function ($agendamento) {
                    return [
                        'cliente' => $agendamento->cliente->name ?? 'Não informado',
                        'horario' => substr($agendamento->horario_disponivel, 0, 5),
                        'servico' => $agendamento->servico->nome_servico ?? 'N/A',
                        'status' => $agendamento->status ?? 0,
                    ];
                })->toArray();
            });

        return view('admin.dashboard', compact('cards', 'agendamentosDia', 'barbeiros', 'agendamentosPorBarbeiro', 'dataSelecionada'));
    }

}
