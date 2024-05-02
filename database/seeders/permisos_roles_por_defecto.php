<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permisos_roles_por_defecto extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Permisos por entidades

        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'desactivar usuarios']);
        Permission::create(['name' => 'borrar usuarios']);

        Permission::create(['name' => 'crear reactivos']);
        Permission::create(['name' => 'ver reactivos']);
        Permission::create(['name' => 'editar reactivos']);
        Permission::create(['name' => 'desactivar usuarios']);
        Permission::create(['name' => 'borrar reactivos']);

        Permission::create(['name' => 'editar residuos']);
        Permission::create(['name' => 'borrar residuos']);
        Permission::create(['name' => 'crear residuos']);
        Permission::create(['name' => 'ver residuos']);

        Permission::create(['name' => 'editar acopios']);
        Permission::create(['name' => 'borrar acopios']);
        Permission::create(['name' => 'crear acopios']);
        Permission::create(['name' => 'ver acopios']);

        Permission::create(['name' => 'editar productos']);
        Permission::create(['name' => 'borrar productos']);
        Permission::create(['name' => 'crear productos']);
        Permission::create(['name' => 'ver productos']);

        Permission::create(['name' => 'editar eventos']);
        Permission::create(['name' => 'borrar eventos']);
        Permission::create(['name' => 'crear eventos']);
        Permission::create(['name' => 'ver eventos']);

        Permission::create(['name' => 'editar provedores']);
        Permission::create(['name' => 'borrar provedores']);
        Permission::create(['name' => 'crear provedores']);
        Permission::create(['name' => 'ver provedores']);
    
    }
}
