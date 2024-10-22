<?php

namespace App\Enums;

enum ChemicalState: string
{
    case Solid = 'solid';
    case Liquid = 'liquid';
    case Gaseous = 'gaseous';
}