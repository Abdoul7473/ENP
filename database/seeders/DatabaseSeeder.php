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
        $this->call(PermissionSeeder::class);
        // Employee::factory(100)->create();
        $this->call(GradeSeeder::class);
        $this->call(EntitesTableSeeder::class);
    }
}
