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

        $horaAtual = Carbon::now();

        foreach ($dias as $dia) {
            foreach ($clientes as $cliente) {

                // Gera um horário aleatório entre 9h e 17h (formato H:i:s)
                $hora = rand(9, 17);
                $horario = sprintf('%02d:00:00', $hora);

                // Status padrão: Confirmado
                $status = StatusAgendamento::Confirmado->value;

                // Se for hoje e a hora já passou, marcar como Atendido
                if ($dia->isSameDay($horaAtual) && $hora < $horaAtual->hour) {
                    $status = StatusAgendamento::Atendido->value;
                } else {
                    // Aleatoriamente definir alguns como Cancelado (20% de chance)
                    if (rand(1, 100) <= 20) {
                        $status = StatusAgendamento::Cancelado->value;
                    }
                }

                Agendamento::create([
                    'data' => $dia->toDateString(),
                    'horario_disponivel' => $horario,
                    'cliente_id' => $cliente->id,
                    'barbeiro_id' => $barbeiros->random()->id,
                    'servico_id' => $servicos->random()->id,
                    'status' => $status,
                ]);

                $this->command->info("Agendamento criado para {$cliente->name} no dia {$dia->toDateString()} às {$horario} com status {$status}");
            }
        }

        $this->command->info('Agendamentos criados com sucesso!');
    }
}
