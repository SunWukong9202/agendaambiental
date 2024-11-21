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

            
    }
}
