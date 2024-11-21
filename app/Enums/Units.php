<?php

namespace App\Enums;

use function Pest\Laravel\instance;

enum Units: string {
    case Milligram = 'milligram';
    case Gram = 'gram';
    case Kilogram = 'kilogram';
    case Milliliter = 'milliliter';
    case Liter = 'liter';
    case Molarity = 'molarity';
    case Mole = 'mole';
    case PartPerMillion = 'ppm';
    case Atmosphere = 'atmosphere';
    case Pascal = 'pascal';
    case VolumePercent = 'volume_percent';
    case WeightPercent = 'weight_percent';

    public static function buildOptions(ChemicalState|string|null $by): array
    {
        if(!$by) return [];
        
        if(is_string($by)) $by = ChemicalState::tryFrom($by);

        return collect(self::options($by))
            ->mapWithKeys(fn($unit) => [
                $unit->value => $unit->getTranslatedLabel()
            ])
            ->toArray();
    }

    public function getTranslatedLabel(): string
    {
        return ucfirst(str_replace('_', ' ', $this->value));
    }

    public static function options(ChemicalState $state): array
    {
        return match($state) {
            ChemicalState::Solid => [
                self::Milligram,
                self::Gram,
                self::Kilogram,
                self::Mole,
                self::WeightPercent,
            ],
            ChemicalState::Liquid => [
                self::Milliliter,
                self::Liter,
                self::Molarity,
                self::Mole,
                self::VolumePercent,
                self::WeightPercent,
            ],
            ChemicalState::Gaseous => [
                self::Mole,
                self::PartPerMillion,
                self::Atmosphere,
                self::Pascal,
            ],
            default => [
                self::Mole,
            ]
        };
    }
}
