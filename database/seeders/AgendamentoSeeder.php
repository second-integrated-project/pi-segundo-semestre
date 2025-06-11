<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Servico;
use Carbon\Carbon;

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
            Carbon::now()->next(Carbon::TUESDAY),
            Carbon::now()->next(Carbon::WEDNESDAY),
            Carbon::now()->next(Carbon::THURSDAY),
            Carbon::now()->next(Carbon::FRIDAY),
            Carbon::now()->next(Carbon::SATURDAY),
            Carbon::now()->next(Carbon::SUNDAY),
        ];

        foreach ($dias as $dia) {
            foreach ($clientes as $cliente) {
                Agendamento::create([
                    'data' => $dia->toDateString(),
                    'horario_disponivel' => sprintf('%02d:00:00', rand(9, 17)),
                    'cliente_id' => $cliente->id,
                    'barbeiro_id' => $barbeiros->random()->id,
                    'servico_id' => $servicos->random()->id
                ]);
                $this->command->info("Agendamento criado para {$cliente->name} no dia {$dia->toDateString()}");
            }
        }

        $this->command->info('Agendamentos criados com sucesso!');
    }
}
