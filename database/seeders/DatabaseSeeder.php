<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'dni_companie' => '9999999999999',
            'admin' => 1,
            'password' => bcrypt('123456')
        ]);

        \App\Models\User::create([
            'name' => 'Salesman',
            'email' => 'salesman@salesman.com',
            'dni_companie' => '9999999999999',
            'salesman' => 1,
            'password' => bcrypt('123456')
        ]);

        \App\Models\User::create([
            'name' => 'Client',
            'email' => 'cliente@cliente.com',
            'dni_companie' => '9999999999999',
            'client' => 1,
            'password' => bcrypt('123456')
        ]);
    }
}
