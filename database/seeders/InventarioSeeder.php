<?php

namespace Database\Seeders;

use App\Models\Inventario;
use Illuminate\Database\Seeder;

class InventarioSeeder extends Seeder
{
    public function run()
    {
        $produtos = [
            ['nome_produto' => 'Pomada Capilar', 'quantidade' => 20, 'quantidade_minima' => 5, 'categoria' => 'Cabelo', 'preco' => 25],
            ['nome_produto' => 'Espuma de Barbear', 'quantidade' => 15, 'quantidade_minima' => 3, 'categoria' => 'Barba', 'preco' => 18],
        ];

        foreach ($produtos as $produto) {
            Inventario::create($produto);
        }
    }
}
