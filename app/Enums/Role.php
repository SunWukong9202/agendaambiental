<?php

namespace App\Enums;


//Este enum es solo para manejar los roles creados
//por defecto con la app, ya que no tenemos forma
//de crear dinamicamente opciones para los nuevos
//roles creados
enum Role: string
{
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Capturist = 'capturist';
    case RepairTechnician = 'repair-technician';

    public function getTranslatedLabel(): string
    {
        return __($this->value);
    }

    public static function readable($label): string
    {
        return self::format($label);
    }

    private static function format(string $label): string
    {
        return ucfirst(str_replace('-', ' ', $label));
    }


}