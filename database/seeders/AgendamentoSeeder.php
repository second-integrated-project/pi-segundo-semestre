<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Servico;
use Carbon\Carbon;
use App\Enums\StatusAgendamento;

class AgendamentoSeeder extends Seeder
{
    public function run()
    {
        $clientes = User::where('role', 'user')->get();
        $barbeiros = User::where('role', 'admin')->get();
        $servicos = Servico::all();

        if ($clientes->isEmpty()) {
            $this->command->info('Nenhum cliente encontrado.');
            return;
        }

        if ($barbeiros->isEmpty()) {
            $this->command->info('Nenhum barbeiro encontrado.');
            return;
        }

        if ($servicos->isEmpty()) {
            $this->command->info('Nenhum serviço encontrado.');
            return;
        }

        $dias = [
            Carbon::now(),
            Carbon::now()->next(Carbon::TUESDAY),
            Carbon::now()->next(Carbon::WEDNESDAY),
            Carbon::now()->next(Carbon::THURSDAY),
            Carbon::now()->next(Carbon::FRIDAY),
            Carbon::now()->next(Carbon::SATURDAY),
            Carbon::now()->next(Carbon::SUNDAY),
        ];

        $horaInicio = Carbon::createFromTime(9, 0, 0); // 9h
        $horaFim = Carbon::createFromTime(18, 0, 0); // 18h
        $intervalo = 45; // minutos fixos

        foreach ($dias as $dia) {
            foreach ($clientes as $cliente) {
                $servico = $servicos->random();
                $barbeiro = $barbeiros->random();

                $horarios = [];
                $horaAtual = $horaInicio->copy();

                while ($horaAtual->copy()->addMinutes($servico->duracao_minutos)->lte($horaFim)) {
                    if ($horaAtual->minute % 45 === 0) {
                        $horarios[] = $horaAtual->format('H:i:s');
                    }
                    $horaAtual->addMinutes($intervalo);
                }

                $agendamentosDia = Agendamento::where('data', $dia->toDateString())
                    ->where('barbeiro_id', $barbeiro->id)
                    ->get();

                $horariosDisponiveis = collect($horarios)->filter(function ($horario) use ($agendamentosDia, $dia, $servico) {
                    $inicio = Carbon::parse($dia->toDateString() . ' ' . $horario);
                    $fim = $inicio->copy()->addMinutes($servico->duracao_minutos);

                    foreach ($agendamentosDia as $ag) {
                        $agInicio = Carbon::parse($dia->toDateString() . ' ' . $ag->horario_disponivel);
                        $agFim = $agInicio->copy()->addMinutes($ag->servico->duracao_minutos);

                        if ($inicio < $agFim && $fim > $agInicio) {
                            return false;
                        }
                    }

                    return true;
                })->values();

                if ($horariosDisponiveis->isEmpty()) {
                    $this->command->warn("Sem horário disponível para {$cliente->name} no dia {$dia->toDateString()}");
                    continue;
                }

                $horario = $horariosDisponiveis->random();

                $status = StatusAgendamento::Confirmado->value;
                $agora = Carbon::now();

                if ($dia->isSameDay($agora) && Carbon::parse($horario)->lt($agora)) {
                    $status = StatusAgendamento::Atendido->value;
                } elseif (rand(1, 100) <= 20) {
                    $status = StatusAgendamento::Cancelado->value;
                }

                Agendamento::create([
                    'data' => $dia->toDateString(),
                    'horario_disponivel' => $horario,
                    'cliente_id' => $cliente->id,
                    'barbeiro_id' => $barbeiro->id,
                    'servico_id' => $servico->id,
                    'status' => $status,
                ]);

                $this->command->info("Agendamento criado para {$cliente->name} em {$dia->toDateString()} às {$horario} ({$status})");
            }
        }

        $this->command->info('Agendamentos criados com sucesso!');
    }
}
