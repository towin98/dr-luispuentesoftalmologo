<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PermissionsSeeder::class);
        $this->call(epsSeeder::class);
        $this->call(ocupacionesSeeder::class);
        Cliente::factory(5)->create(); // SOLO PARA PRUEBAS
    }
}
