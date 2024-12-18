<?php

namespace Database\Seeders;

use App\Enums\TipoConta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = TipoConta::cases_names();
        collect($roles)->each(fn($role) => Role::createOrFirst(['name' => $role]));
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
            'despachar-docs',

            'create-engenheiros',
            'edit-engenheiros',
            'view-engenheiros',
            'show-engenheiros',
            'delete-engenheiros',

            'show-valores',

            'show-vendedores',
            'edit-vendedores',
            'delete-vendedores',
            'create-vendedores',
            'view-vendedores',

            'show-clientes',
            'view-clientes',
            'edit-clientes',
            'delete-clientes',
            'create-clientes',

        ];
        collect($permissions)
            ->each(
                fn($per) => Permission::createOrFirst(['name' => $per])
            );
        $admin = Role::findByName(TipoConta::ADMIN->name);
        $admin->givePermissionTo(...$permissions);

        Role::findByName(TipoConta::ENGENHEIRO->name)->givePermissionTo([
            'create-docs',
            'show-clientes',
            'view-clientes',
            'view-docs',
            'show-docs',
            'view-pedidos',
            'show-pedidos',
        ]);;
        Role::findByName(TipoConta::VENDEDOR->name)->givePermissionTo([
            'show-clientes',
            'view-clientes',
            'edit-clientes',
            'create-docs',
        
            'edit-docs',
            'view-docs',
            'show-docs',
            'create-docs', 

            'view-pedidos',
            'show-pedidos',
        ]);

        Role::findByName(TipoConta::INSTALADOR->name)->givePermissionTo([
            'show-clientes',
            'view-clientes',
            'view-pedidos',
            'show-pedidos',
        
            'create-docs', 
            'show-docs',
            'view-docs',
            'show-docs',

            
        ]);

    }
}
