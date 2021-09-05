<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Crea un usuario administrador
        User::create([
            'name' => 'Administrador',
            'last_name' => 'Administrador',
            'email' => 'admin@email.com',
            'role' => 0,
            'password' => Hash::make('12345'),
        ]);
        //Crea un usuario profesor
        User::create([
            'name' => 'Profesor',
            'last_name' => 'Profesor',
            'email' => 'profesor@email.com',
            'role' => 1,
            'password' => Hash::make('12345'),
        ]);
        //Crea un usuario estudiante
        User::create([
            'name' => 'Estudiante',
            'last_name' => 'Estudiante',
            'email' => 'estudiante@email.com',
            'role' => 2,
            'password' => Hash::make('12345'),
        ]);

    }
}
