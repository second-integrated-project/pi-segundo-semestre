<?php

namespace Database\Seeders;

use App\Models\Pacote;
use Illuminate\Database\Seeder;

class PacoteSeeder extends Seeder
{
    public function run()
    {
        Pacote::create([
            'nome_pacote' => 'Mensal',
            'descricao' => '4 cortes por mês',
            'valor' => 100
        ]);

        Pacote::create([
            'nome_pacote' => 'VIP',
            'descricao' => 'Serviços ilimitados por mês',
            'valor' => 250
        ]);
    }
}
