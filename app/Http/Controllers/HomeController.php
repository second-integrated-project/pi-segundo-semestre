<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Servico;
use App\Models\User;
use App\Models\Agendamento;
class HomeController extends Controller

{
    public function index() {

        $hoje = Carbon::today();
        $agendamentosHoje = Agendamento::whereDate('data', $hoje)->with('servico') ->get();
        $agendamentos = Agendamento::whereDate('data', $hoje)->count();
        $clientesAtendidos = Agendamento::whereDate('data', $hoje)->distinct('cliente_id')->count();
        $faturamento = $agendamentosHoje->sum(function ($agendamento) {
            return $agendamento->servico->valor ?? 0;});
        $servicosRealizados = Agendamento::whereDate('data', $hoje)->with('servico')->distinct('servico_id')->count('servico_id');
    
        $cards = [
            ['title' => 'Agendamentos Hoje', 'value' => $agendamentos, 'change' => '+8.5%', 'icon' => 'calendar'],
            ['title' => 'Clientes Atendidos', 'value' => $clientesAtendidos, 'change' => '+5.2%', 'icon' => 'users'],
            ['title' => 'Faturamento', 'value' => 'R$ ' . number_format($faturamento, 2, ',', '.'), 'change' => '+12.3%', 'icon' => 'dollar-sign'],
            ['title' => 'Serviços Realizados', 'value' => $servicosRealizados, 'change' => '-2.5%', 'icon' => 'scissors'],
        ];

        $agendamentos_dia = Agendamento::whereDate('data', $hoje)
        ->with(['barbeiro', 'servico', 'cliente']) 
        ->orderBy('horario_disponivel')
        ->get()
        ->map(function ($a) {
            return [
                'cliente' => $a->cliente->name ?? 'Não informado',
                'horario' => $a->horario_disponivel ?? '00:00',
                'servico' => $a->servico->nome_servico ?? 'N/A',
                'barbeiro' => $a->barbeiro->name ?? 'N/A',
                'status' => $a->status ?? 'Pendente',
            ];
        });

        $barbeiros = User::where('role', 'admin')
        ->get()
        ->map(function ($barbeiro) use ($hoje) {
            $agendamentos = $barbeiro->agendamentos()->whereDate('data', $hoje)->get();
            $total = $agendamentos->count();
            $valor = $agendamentos->sum(function ($ag) {
                return $ag->servico->valor ?? 0;
            });
            return [
                'nome' => $barbeiro->name,
                'valor' => 'R$ ' . number_format($valor, 2, ',', '.'),
                'agendamentos' => "$total/10", // exemplo de meta
                'percent' => $total * 10, // supondo meta de 10
            ];
        });
    
    
        return view('admin.dashboard', compact('cards', 'agendamentos_dia', 'barbeiros'));
    }
}