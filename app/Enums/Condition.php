<?php

namespace App\Enums;

enum Condition: string 
{
    case New = 'nuevo';
    case Second_hand = 'semi nuevo';
    case Used = 'usado';
}
