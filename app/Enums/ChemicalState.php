<?php

namespace App\Enums;

enum ChemicalState: string
{
    use Transformers;
    
    case Solid = 'solid';
    case Liquid = 'liquid';
    case Gaseous = 'gaseous';

    public function getTranslatedLabel()
    {
        return __(ucfirst($this->value));
    }
}