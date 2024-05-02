<?php

namespace App\Enums;

enum Estado: string
{
    case Solido = 'S';
    case Liquido = 'L';
    case Gaseoso = 'G';
}