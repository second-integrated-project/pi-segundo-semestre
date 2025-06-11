<?php

namespace Database\Seeders;

use App\Models\Servico;
use Illuminate\Database\Seeder;

class ServicoSeeder extends Seeder
{
    public function run()
    {
        $servicos = [
            ['nome_servico' => 'Corte de Cabelo', 'descricao' => 'Corte profissional', 'valor' => 30, 'valor_fim_semana' => 40, 'duracao_minutos' => 45],
            ['nome_servico' => 'Barba', 'descricao' => 'Modelagem e acabamento', 'valor' => 20, 'valor_fim_semana' => 25, 'duracao_minutos' => 45],
            ['nome_servico' => 'Corte + Barba', 'descricao' => 'Pacote completo', 'valor' => 45, 'valor_fim_semana' => 55, 'duracao_minutos' => 90],
        ];

        foreach ($servicos as $servico) {
            Servico::create($servico);
        }
    }
}
