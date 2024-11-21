<?php

namespace App\Enums;

enum CRETIB: string
{
    use Transformers;

    case Corrosive = 'C';
    case Reactive = 'R';
    case Explosive = 'E';
    case Toxic = 'T';
    case Inflamable = 'I';
    case Biologico_Infeccioso = 'B';

    public function getTranslatedLabel(): string
    {
        return __((string) str($this->name)->replace('_', ' '));
    }

    public static function descriptions(): array
    {
        return [
            self::Corrosive->value => __('Substance can cause severe damage to living tissue or materials.'),
            self::Reactive->value => __('Substance can undergo violent reactions, releasing energy, heat, or toxic substances.'),
            self::Explosive->value => __('Substance can cause explosions under certain conditions, posing a risk of damage and injury.'),
            self::Toxic->value => __('Substance is harmful or lethal when inhaled, ingested, or absorbed.'),
            self::Inflamable->value => __('Substance can ignite easily and burn rapidly when exposed to open flames or sparks.'),
            self::Biologico_Infeccioso->value => __('Substance contains or may contain pathogenic organisms that pose a biological hazard.'),
        ];
    }
}