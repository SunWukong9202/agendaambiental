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
        //reseatea los roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Permisos por entidades

        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'deshabilitar usuarios']);
        Permission::create(['name' => 'habilitar usuarios']);
        Permission::create(['name' => 'ver reactivos']);
        Permission::create(['name' => 'crear reactivos']);
        Permission::create(['name' => 'editar reactivos']);
        Permission::create(['name' => 'eliminar reactivos']);
        Permission::create(['name' => 'deshabilitar reactivos']);
        Permission::create(['name' => 'habilitar reactivos']);
        Permission::create(['name' => 'ver residuos']);
        Permission::create(['name' => 'crear residuos']);
        Permission::create(['name' => 'editar residuos']);
        Permission::create(['name' => 'eliminar residuos']);
        Permission::create(['name' => 'deshabiltar residuos']);
        Permission::create(['name' => 'habilitar residuos']);
        Permission::create(['name' => 'ver eventos']);
        Permission::create(['name' => 'crear eventos']);
        Permission::create(['name' => 'editar eventos']);
        Permission::create(['name' => 'eliminar eventos']);
        Permission::create(['name' => 'despublicar eventos']);
        Permission::create(['name' => 'publicar eventos']);
        Permission::create(['name' => 'ver acopios']);
        Permission::create(['name' => 'crear acopios']);
        Permission::create(['name' => 'editar acopios']);
        Permission::create(['name' => 'eliminar acopios']);
        Permission::create(['name' => 'deshabiltar acopios']);
        Permission::create(['name' => 'habilitar acopios']);
        Permission::create(['name' => 'ver productos']);
        Permission::create(['name' => 'crear productos']);
        Permission::create(['name' => 'editar productos']);
        Permission::create(['name' => 'eliminar productos']);
        Permission::create(['name' => 'deshabiltar productos']);
        Permission::create(['name' => 'habilitar productos']);
        Permission::create(['name' => 'ver proveedores']);
        Permission::create(['name' => 'crear proveedores']);
        Permission::create(['name' => 'editar proveedores']);
        Permission::create(['name' => 'eliminar proveedores']);
        Permission::create(['name' => 'deshabiltar proveedores']);
        Permission::create(['name' => 'habilitar proveedores']);    
    }
}
