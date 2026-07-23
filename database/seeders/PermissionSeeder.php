<?php

namespace Database\Seeders;

use App\Models\Aeroport;
use App\Models\TypeUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $models = [
        'encadreur' => 'un encadreur',
        'role' => 'un rôle',
        'user' => 'un utilisateur',
        'compagnie' => 'une compagnie',
        'visiteur' => 'un visiteur',
        'situation' => 'une situation',
        'élève' => 'un élève',
    ];

    public function run()
    {
        Permission::create(['name' => 'manage_system', 'description' => 'Paramètrer système']);
        Permission::create(['name' => 'signature', 'description' => 'Signature des cartes']);
        Permission::create(['name' => 'generate_card', 'description' => 'Génrer carte']);
        foreach ($this->models as $k => $v) {
            Permission::create(['name' => $k . '.create', 'description' => 'Ajouter ' . $v]);
            Permission::create(['name' => $k . '.read', 'description' => 'Voir ' . $v]);
            Permission::create(['name' => $k . '.update', 'description' => 'Modifier ' . $v]);
            Permission::create(['name' => $k . '.delete', 'description' => 'Supprimer ' . $v]);
        }
        $admin = User::create([
            'name' => 'Admin système',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'statut' => 1,
            'first_login' =>1
        ]);
        $super_admin = Role::firstOrcreate(['name' => 'Administrateur']);
        $super_admin->givePermissionTo(Permission::all());
        $admin->assignRole($super_admin);

        TypeUser::create([
            "libelle" => "Administrateur"
        ]);
        TypeUser::create([
            "libelle" => "Directeur"
        ]);
        TypeUser::create([
            "libelle" => "DSI"
        ]);
        TypeUser::create([
            "libelle" => "DAM"
        ]);
        TypeUser::create([
            "libelle" => "CE"
        ]);
    }
}
