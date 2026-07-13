<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\TypeAutorisation;
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
        $this->call(PaysTableSeeder::class);
        $this->call(VillesTableSeeder::class);
        $this->call(StatutSeeder::class);
        $this->call(TypePostulantSeeder::class);
        $this->call(PostulantSeeder::class);
        $this->call(PermissionSeeder::class);
        // Employee::factory(100)->create();
        $this->call(TypeAutorisationSeeder::class);
        $this->call(TypeDemandeSeeder::class);
        $this->call(TypeVolSeeder::class);
        $this->call(FichierRequiSeeder::class);
        $this->call(CapitalTableSeeder::class);
        
        $this->call(FraisTableSeeder::class);
        $this->call(GradeSeeder::class);
    }
}
