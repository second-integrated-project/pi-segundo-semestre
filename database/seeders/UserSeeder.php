<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'João',
            'email' => 'joao@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'active' => true
        ]);
        
        // Criando barbeiros
        User::factory()->create([
            'name' => 'Barbeiro 1',
            'email' => 'barbeiro1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'active' => true
        ]);


        User::factory()->create([
            'name' => 'Barbeiro 2',
            'email' => 'barbeiro2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'active' => true
        ]);

        // Criando clientes
        User::factory(10)->create([
            'role' => 'user',
            'active' => true
        ]);
    }
}
