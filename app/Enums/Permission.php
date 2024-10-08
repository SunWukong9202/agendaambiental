<?php

namespace App\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum Permission: string
{
    case VER_USUARIOS = 'ver usuarios';
    case CREAR_USUARIOS = 'crear usuarios';
    case EDITAR_USUARIOS = 'editar usuarios';
    case ELIMINAR_USUARIOS = 'eliminar usuarios';
    case DESHABILITAR_USUARIOS = 'deshabilitar usuarios';
    case HABILITAR_USUARIOS = 'habilitar usuarios';

    // case REGISTRAR_DONANTES = 'registrar donantes';

    case VER_REACTIVOS = 'ver reactivos';
    case CREAR_REACTIVOS = 'crear reactivos';
    case EDITAR_REACTIVOS = 'editar reactivos';
    case ELIMINAR_REACTIVOS = 'eliminar reactivos';
    case DESHABILITAR_REACTIVOS = 'deshabilitar reactivos';
    case HABILITAR_REACTIVOS = 'habilitar reactivos';

    case DONAR_REACTIVOS = 'donar reactivos';
    case SOLICITAR_REACTIVOS = 'solicitar reactivos';

    case VER_RESIDUOS = 'ver residuos';
    case CREAR_RESIDUOS = 'crear residuos';
    case EDITAR_RESIDUOS = 'editar residuos';
    case ELIMINAR_RESIDUOS = 'eliminar residuos';
    case DESHABILTAR_RESIDUOS = 'deshabiltar residuos';
    case HABILITAR_RESIDUOS = 'habilitar residuos';

    case VER_EVENTOS = 'ver eventos';
    case CREAR_EVENTOS = 'crear eventos';
    case EDITAR_EVENTOS = 'editar eventos';
    case ELIMINAR_EVENTOS = 'eliminar eventos';
    case DESPUBLICAR_EVENTOS = 'despublicar eventos';
    case PUBLICAR_EVENTOS = 'publicar eventos';
    case VER_EVENTOS_DESPUBLICADOS = 'ver eventos despublicados';

    case VER_ACOPIOS = 'ver acopios';
    case CREAR_ACOPIOS = 'crear acopios';
    case EDITAR_ACOPIOS = 'editar acopios';
    case ELIMINAR_ACOPIOS = 'eliminar acopios';
    case DESHABILTAR_ACOPIOS = 'deshabiltar acopios';
    case HABILITAR_ACOPIOS = 'habilitar acopios';

    case VER_ACOPIO_ACTIVO = 'ver acopio habilitado';

    case VER_PRODUCTOS = 'ver productos';
    case CREAR_PRODUCTOS = 'crear productos';
    case EDITAR_PRODUCTOS = 'editar productos';
    case ELIMINAR_PRODUCTOS = 'eliminar productos';
    case DESHABILTAR_PRODUCTOS = 'deshabiltar productos';
    case HABILITAR_PRODUCTOS = 'habilitar productos';

    case VER_PROVEEDORES = 'ver proveedores';
    case CREAR_PROVEEDORES = 'crear proveedores';
    case EDITAR_PROVEEDORES = 'editar proveedores';
    case ELIMINAR_PROVEEDORES = 'eliminar proveedores';
    case DESHABILTAR_PROVEEDORES = 'deshabiltar proveedores';
    case HABILITAR_PROVEEDORES = 'habilitar proveedores';

    case VER_ADMIN_PANEL = 'ver admin panel';
    case VER_USERS = 'ver usuarios en panel de administrador';

    case VER_ROLES = 'ver pagina de roles';
    case CREAR_ROLES = 'crear roles';
    case EDITAR_ROLES = 'editar roles';
    case REMOVER_ROLES = 'remover roles';
    case ASIGNAR_ROLES = 'asignar roles';

    /**
     * Function to filter permissions for types of resources
     *
     * @param [type] $categories
     * @return Collection
     */
    public static function casesFor($categories): Collection
    {
        $cases = new Collection(self::cases());
        $categories = new Collection(explode('|', $categories));
        return $cases->filter(fn($permission) 
            => $categories->contains(fn($value) 
            => Str::contains($permission->value, $value))
        );
    }

    public function descripcion(): string
    {
        return match($this->name) {
            'VER_REACTIVOS' => '',
            'CREAR_REACTIVOS' => '',
            'EDITAR_REACTIVOS' => '',
            'ELIMINAR_REACTIVOS' => '',
            'DESHABILITAR_REACTIVOS' => '',
            'HABILITAR_REACTIVOS' => '',
            'DONAR_REACTIVOS' => '',
            'SOLICITAR_REACTIVOS' => '',
            'VER_RESIDUOS' => '',
            'CREAR_RESIDUOS' => '',
            'EDITAR_RESIDUOS' => '',
            'ELIMINAR_RESIDUOS' => '',
            'DESHABILTAR_RESIDUOS' => '',
            'HABILITAR_RESIDUOS' => '',
            'VER_EVENTOS' => '',
            'CREAR_EVENTOS' => '',
            'EDITAR_EVENTOS' => '',
            'ELIMINAR_EVENTOS' => '',
            'DESPUBLICAR_EVENTOS' => '',
            'PUBLICAR_EVENTOS' => '',
            'VER_EVENTOS_DESPUBLICADOS' => '',
            'VER_ACOPIOS' => '',
            'CREAR_ACOPIOS' => '',
            'EDITAR_ACOPIOS' => '',
            'ELIMINAR_ACOPIOS' => '',
            'DESHABILTAR_ACOPIOS' => '',
            'HABILITAR_ACOPIOS' => '',
            'VER_ACOPIO_ACTIVO' => '',
            'VER_PRODUCTOS' => '',
            'CREAR_PRODUCTOS' => '',
            'EDITAR_PRODUCTOS' => '',
            'ELIMINAR_PRODUCTOS' => '',
            'DESHABILTAR_PRODUCTOS' => '',
            'HABILITAR_PRODUCTOS' => '',
            'VER_PROVEEDORES' => '',
            'CREAR_PROVEEDORES' => '',
            'EDITAR_PROVEEDORES' => '',
            'ELIMINAR_PROVEEDORES' => '',
            'DESHABILTAR_PROVEEDORES' => '',
            'HABILITAR_PROVEEDORES' => '',
            'VER_ADMIN_PANEL' => '',
            'VER_USERS' => '',
            'VER_ROLES' => '',
            'CREAR_ROLES' => '',
            'EDITAR_ROLES' => '',
            'REMOVER_ROLES' => '',
            'ASIGNAR_ROLES' => '',
        };
    }
}
