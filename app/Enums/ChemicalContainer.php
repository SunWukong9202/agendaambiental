<?php

namespace App\Enums;

enum ChemicalContainer: string
{
    use Transformers;

    case Plastic = 'plastic';
    case Glass = 'glass';
    case Bottle = 'bottle';
    case PlasticBag = 'plastic-bag';
    case Box = 'box';
    case Other = 'other';

    public function getTranslatedLabel()
    {
        return __(ucfirst($this->value));
    }
}