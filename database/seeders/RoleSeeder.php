<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::create([
            'id' => 1,
            'name' => 'admin'
        ]);
        Rol::create([
            'id' => 2,
            'name' => 'usuario'
        ]);
        
    }
}
