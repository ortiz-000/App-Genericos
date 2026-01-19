<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ADMINISTRADOR
        $admin = User::create([
            'name' => 'deleted',
            'email' => 'deleted@example.com',
            'password' => bcrypt('1234567'),
            'rol' => 'admin',
            'cedula' =>'11172396670',
            'telefono'=>'3207266712',
        ]);

        $admin->assignRole('admin');

        //VENDEDOR
        $vendedor = User::create([
            'name' => 'jhon',
            'email' => 'jh@example.com',
            'password' => bcrypt('12345678'),
            'rol' => 'vendedor',
             'cedula' =>'1338234550',
            'telefono'=>'3505899612',
        ]);

        $vendedor->assignRole('vendedor');
    }
}
