<?php

namespace App\Http\Controllers;

use App\Enums\StatusAgendamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Servico;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::where('cliente_id', Auth::id())->get();
        return view('agendamento.index', compact("agendamentos"));
    }
public function create()
{
    $user = Auth::user();

    $hoje = Carbon::now();
    $diaSemana = $hoje->dayOfWeek;

    // Calcula terça-feira da semana atual
    if ($diaSemana === 0) {
        $terca = $hoje->copy()->subDays(6); // domingo -> volta até terça
    } else {
        $terca = $hoje->copy()->startOfWeek()->addDay(); // segunda + 1 = terça
    }

    $domingo = $terca->copy()->addDays(5); // Terça até domingo

    $diasSemana = [];

    for ($data = $terca->copy(); $data->lte($domingo); $data->addDay()) {
        if ($user?->role !== 'admin' && $data->isSameDay($hoje)) {
            continue; // Clientes não podem agendar para o mesmo dia
        }

        if ($data->gt($hoje) || $user?->role === 'admin') {
            $diasSemana[] = [
                'label' => $data->format('d/m'),
                'value' => $data->format('Y-m-d'),
            ];
        }
    }

    $barbeiros = User::where('role', 'admin')->get();
    $servicos = Servico::all();

    return view('agendamento.create', compact('barbeiros', 'servicos', 'diasSemana'));
}


   public function store(Request $request)
{
    $dados = $request->validate([
        'data' => 'required|date',
        'barbeiro_id' => 'required|exists:users,id',
        'servico_id' => 'required|exists:servicos,id',
        'horario' => 'required|date_format:H:i',
    ]);

    $servico = Servico::findOrFail($dados['servico_id']);
    $duracaoServico = $servico->duracao_minutos;

    $dataSelecionada = Carbon::parse($dados['data']);
    $novoInicio = Carbon::parse($dados['data'] . ' ' . $dados['horario']);
    $novoFim = $novoInicio->copy()->addMinutes($duracaoServico);

    $agendamentos = Agendamento::where('barbeiro_id', $dados['barbeiro_id'])
        ->where('data', $dados['data'])
        ->where('status', StatusAgendamento::Confirmado->value)
        ->get();

    foreach ($agendamentos as $agendamento) {
        $inicioExistente = Carbon::parse($dados['data'] . ' ' . $agendamento->horario_disponivel);
        $fimExistente = $inicioExistente->copy()->addMinutes($agendamento->servico->duracao_minutos);

        if ($novoInicio->lt($fimExistente) && $novoFim->gt($inicioExistente)) {
            return redirect()->back()->with('error', 'Horário já ocupado.');
        }
    }

    $valorServico = $dataSelecionada->isWeekend()
        ? $servico->valor_fim_semana
        : $servico->valor;

    Agendamento::create([
        'data' => $dados['data'],
        'barbeiro_id' => $dados['barbeiro_id'],
        'cliente_id' => auth()->id(),
        'servico_id' => $dados['servico_id'],
        'horario_disponivel' => $dados['horario'],
        'valor' => $valorServico,
        'status' => StatusAgendamento::Confirmado->value,
    ]);

    return redirect()->route('agendamento.index')->with('success', 'Agendamento realizado com sucesso!');
}

public function cancelar($id)
    {
        $agendamento = Agendamento::findOrFail($id);

        if ($agendamento->cliente_id != Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }

        $agendamento->status = StatusAgendamento::Cancelado->value;
        $agendamento->save();

        return redirect('/agendamento')->with('success', 'Agendamento cancelado com sucesso!');
    }


    public function confirmar($id)
    {
        $agendamento = Agendamento::findOrFail($id);

        if ($agendamento->cliente_id != Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }

        // Verifica se o horário está disponível para o barbeiro
        $conflito = Agendamento::where('barbeiro_id', $agendamento->barbeiro_id)
            ->where('data', $agendamento->data)
            ->where('horario_disponivel', $agendamento->horario_disponivel)
            ->where('status', StatusAgendamento::Confirmado->value)
            ->where('id', '<>', $agendamento->id)
            ->exists();

        if ($conflito) {
            return redirect('/agendamento')->with('error', 'Este horário já está ocupado por outro agendamento confirmado.');
        }

        $agendamento->status = StatusAgendamento::Confirmado->value;
        $agendamento->save();

        return redirect('/agendamento')->with('success', 'Agendamento confirmado com sucesso!');
    }



    // Método para retornar horários disponíveis via AJAX
   public function horariosDisponiveis(Request $request)
{
    $request->validate([
        'data' => 'required|date',
        'barbeiro_id' => 'required|exists:users,id',
        'servico_id' => 'required|exists:servicos,id',
    ]);

    $data = $request->input('data');
    $barbeiroId = $request->input('barbeiro_id');
    $servico = Servico::findOrFail($request->input('servico_id'));
    $duracaoServico = $servico->duracao_minutos;

    $inicioDia = Carbon::parse($data)->setHour(9)->setMinute(0);
    $fimDia = Carbon::parse($data)->setHour(18)->setMinute(0);

    $intervalo = 15; // maior precisão de encaixe

    $agendamentos = Agendamento::where('data', $data)
        ->where('barbeiro_id', $barbeiroId)
        ->where('status', StatusAgendamento::Confirmado->value)
        ->get();

    $horariosDisponiveis = [];

    for (
        $hora = $inicioDia->copy();
        $hora->lte($fimDia->copy()->subMinutes($duracaoServico));
        $hora->addMinutes($intervalo)
    ) {
        $horarioInicio = $hora->copy();
        $horarioFim = $hora->copy()->addMinutes($duracaoServico);

        $conflito = $agendamentos->first(function ($ag) use ($data, $horarioInicio, $horarioFim) {
            $agInicio = Carbon::parse($data . ' ' . $ag->horario_disponivel);
            $agFim = $agInicio->copy()->addMinutes($ag->servico->duracao_minutos);

            return $horarioInicio->lt($agFim) && $horarioFim->gt($agInicio);
        });

        if (!$conflito) {
            $horariosDisponiveis[] = $horarioInicio->format('H:i');
        }
    }

    return response()->json($horariosDisponiveis);
}

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:confirmado,cancelado,atendido'],
        ]);

        $agendamento = Agendamento::findOrFail($id);

        // Exemplo de autorização simples, ajuste conforme sua regra
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }

        $novoStatus = StatusAgendamento::from($request->input('status'));
        $agendamento->status = $novoStatus->value;
        $agendamento->save();

        return redirect()->back()->with('success', "Status atualizado para {$novoStatus->label()}.");
    }

}
