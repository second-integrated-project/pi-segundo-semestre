<?php

namespace App\Http\Controllers;

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
        $hoje = Carbon::now();
        $diaSemana = $hoje->dayOfWeek;

        // A semana da barbearia começa na terça (2) e termina no domingo (0)
        // Ajusta a terça da semana atual
        if ($diaSemana == 0) {
            $terca = $hoje->copy()->subDays(5);
        } else {
            $terca = $hoje->copy()->startOfWeek()->addDay(); // startOfWeek = segunda (1), add 1 dia = terça (2)
        }

        $domingo = $hoje->copy()->endOfWeek(); // domingo

        $diasSemana = [];

        for ($data = $terca->copy(); $data->lessThanOrEqualTo($domingo); $data->addDay()) {
            if ($data->isSameDay($hoje)) {
                // Pula o dia atual para não permitir agendamento para o mesmo dia
                continue;
            }
            if ($data->greaterThan($hoje)) {
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

        // Verifica se o horário está disponível (não existe agendamento com conflito)
        $agendamentos = Agendamento::where('barbeiro_id', $dados['barbeiro_id'])
            ->where('data', $dados['data'])
            ->get();

        $servico = Servico::findOrFail($dados['servico_id']);
        $duracaoServico = $servico->duracao; // minutos

        $novoInicio = Carbon::createFromFormat('H:i', $dados['horario']);
        $novoFim = $novoInicio->copy()->addMinutes($duracaoServico);

        foreach ($agendamentos as $agendamento) {
            $agendamentoServico = Servico::findOrFail($agendamento->servico_id);
            $agendamentoDuracao = $agendamentoServico->duracao;

            $inicioExistente = Carbon::parse($agendamento->horario_disponivel);

            $fimExistente = $inicioExistente->copy()->addMinutes($agendamentoDuracao);

            // Verifica sobreposição
            if ($novoInicio->lt($fimExistente) && $novoFim->gt($inicioExistente)) {
                return redirect()->back()->with('error', 'Horário já ocupado.');
            }
        }

        Agendamento::create([
            'data' => $dados['data'],
            'barbeiro_id' => $dados['barbeiro_id'],
            'cliente_id' => auth()->id(),
            'servico_id' => $dados['servico_id'],
            'horario_disponivel' => $dados['horario'],
        ]);

        return redirect()->route('agendamento.index')->with('success', 'Agendamento realizado com sucesso!');
    }

    public function cancelar($id)
    {
        $agendamento = Agendamento::findOrFail($id);

        if ($agendamento->cliente_id != Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }

        $agendamento->status = false;
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
            ->where('status', 1) // já confirmado
            ->where('id', '<>', $agendamento->id) // exclui o próprio agendamento atual
            ->exists();

        if ($conflito) {
            return redirect('/agendamento')->with('error', 'Este horário já está ocupado por outro agendamento confirmado.');
        }

        $agendamento->status = true;
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

        $intervaloMinutos = 15; // Ajustado para 15 minutos
        $duracaoServicoMin = $servico->duracao_minutos;

        $horariosDisponiveis = [];

        $agendamentos = Agendamento::where('data', $data)
            ->where('barbeiro_id', $barbeiroId)
            ->where('status', true) // Verifique se tem esse campo 'status' no model
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

}
