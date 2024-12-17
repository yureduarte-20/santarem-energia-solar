<?php

namespace Database\Seeders;

use App\Enums\TipoConta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = TipoConta::cases_names();
        collect($roles)->each(fn ($role) => Role::createOrFirst(['name' => $role]));
        $permissions = [

            'create-user',
            'edit-user',
            'delete-user',
            'view-user',
            'show-user',

            'create-pedidos',
            'edit-pedidos',
            'delete-pedidos',
            'view-pedidos',
            'show-pedidos',

            'create-docs',
            'delete-docs',
            'edit-docs',
            'view-docs',
            'show-docs',

            'create-engenheiro',
            'edit-engenheiro',
            'view-engenheiro',
            'show-engenheiro',
            'delete-engenheiro',

            'show-valores',

            'show-vendedores',
            'edit-vendedores',
            'delete-vendedores',
            'create-vendedores',
            'view-vendedores'

        ];
    }
}
