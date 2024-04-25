<?php

namespace App\Enums;

enum Estado: string
{
    case Solido = 'S';
    case Liquido = 'L';
    case Gaseoso = 'G';
}

enum Condicion: string 
{
    case Nuevo = 'N';
    case Seminuevo = 'SN';
    case Usado = 'U';
}

enum CRETIB: string
{
    case Corrosivo = 'C';
    case Reactivo = 'R';
    case Explosivo = 'E';
    case Toxico = 'T';
    case Inflamable = 'I';
    case Biologico_Infeccioso = 'B';

    public function label(): string
    {
        return (string) str($this->name)->replace('_', ' ');
    }
}

enum Solicitud: string
{
    case Aprobada = 'A';
    case En_Proceso = 'EP';

    public function label(): string
    {
        return (string) str($this->name)->replace('_', ' ');
    }
}

