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

        // A semana da barbearia começa na terça (2) e termina no domingo (0)
        // Ajusta a terça da semana atual
        if ($diaSemana == 0) {
            $terca = $hoje->copy()->subDays(5);
        } else {
            $terca = $hoje->copy()->startOfWeek()->addDay(); // startOfWeek = segunda (1), add 1 dia = terça (2)
        }

        $domingo = $hoje->copy()->endOfWeek()->addDay(); // domingo

        $diasSemana = [];

        for ($data = $terca->copy(); $data->lessThanOrEqualTo($domingo); $data->addDay()) {
            if ($user?->role == 'admin' && $data->isSameDay($hoje)) {
                // Se não for admin, pula o dia atual para não permitir agendamento para o mesmo dia
                continue;
            }
            if ($data->greaterThan($hoje) || $user?->role == 'admin') {
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
            'horario' => 'required',
        ]);

        $servico = Servico::findOrFail($dados['servico_id']);
        $duracaoServico = $servico->duracao_minutos;

        $novoInicio = Carbon::createFromFormat('H:i', $dados['horario']);
        $novoFim = $novoInicio->copy()->addMinutes($duracaoServico);

        $agendamentos = Agendamento::where('barbeiro_id', $dados['barbeiro_id'])
            ->where('data', $dados['data'])
            ->get();

        foreach ($agendamentos as $agendamento) {
            $inicioExistente = Carbon::parse($agendamento->horario_disponivel);
            $duracaoExistente = $agendamento->servico->duracao_minutos;
            $fimExistente = $inicioExistente->copy()->addMinutes($duracaoExistente);

            if ($novoInicio->lt($fimExistente) && $novoFim->gt($inicioExistente)) {
                return redirect()->back()->with('error', 'Horário já ocupado.');
            }
        }

        $dataSelecionada = Carbon::parse($dados['data']);
        $valorServico = $dataSelecionada->isWeekend() ? $servico->valor_fim_semana : $servico->valor;

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
        $servicoId = $request->input('servico_id');

        $servico = Servico::findOrFail($servicoId);

        $inicioDia = Carbon::parse($data)->setHour(9)->setMinute(0);
        $fimDia = Carbon::parse($data)->setHour(18)->setMinute(0);

        $intervaloMinutos = 45;
        $duracaoServicoMin = $servico->duracao_minutos;

        $horariosDisponiveis = [];

        $agendamentos = Agendamento::where('data', $data)
            ->where('barbeiro_id', $barbeiroId)
            ->where('status', StatusAgendamento::Confirmado->value) // Verifique se tem esse campo 'status' no model
            ->get();

        foreach ($agendamentos as $ag) {
            // Verifique o valor para debug:
            \Log::info('Agendamento horário_disponivel: ' . $ag->horario_disponivel);
        }

        for ($hora = $inicioDia->copy(); $hora->lte($fimDia->copy()->subMinutes($duracaoServicoMin)); $hora->addMinutes($intervaloMinutos)) {
            $horarioInicio = $hora->copy();
            $horarioFim = $hora->copy()->addMinutes($duracaoServicoMin);

            $conflito = $agendamentos->first(function ($ag) use ($horarioInicio, $horarioFim, $data) {
                $agInicio = Carbon::parse($data . ' ' . $ag->horario_disponivel);
                $agFim = $agInicio->copy()->addMinutes($ag->servico->duracao_minutos);
                return $horarioInicio < $agFim && $horarioFim > $agInicio;
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
