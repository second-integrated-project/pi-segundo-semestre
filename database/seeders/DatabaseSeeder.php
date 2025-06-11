<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServicoSeeder::class,
            PacoteSeeder::class,
            InventarioSeeder::class,
            AgendamentoSeeder::class,
        ]);
    }

    // public function run(): void
    // {
    //     // User::factory(10)->create();

    //     User::factory()->create([
    //         'name' => 'Murilo',
    //         'email' => 'admin@gmail.com',
    //         'role' => 'admin',
    //         'password' => '12345678',
    //     ]);

    //     User::factory()->create([
    //         'name' => 'Rafael',
    //         'email' => 'user@gmail.com',
    //         'role' => 'user',
    //         'password' => '12345678',
    //     ]);

    //     User::factory()->create([
    //         'name' => 'barbeiro1',
    //         'email' => 'barbeiro1@test.com',
    //         'role' => 'admin',
    //         'password' => '12345678',
    //     ]);
    //     User::factory()->create([
    //         'name' => 'barbeiro2',
    //         'email' => 'barbeiro2@test.com',
    //         'role' => 'admin',
    //         'password' => '12345678',
    //     ]);
    //     User::factory()->create([
    //         'name' => 'barbeiro3',
    //         'email' => 'barbeiro3@test.com',
    //         'role' => 'admin',
    //         'password' => '12345678',
    //     ]);


    // }
}
