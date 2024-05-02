<?php

namespace App\Enums;

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