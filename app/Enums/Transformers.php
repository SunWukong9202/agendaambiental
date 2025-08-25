<?php

namespace App\Enums;

trait Transformers {

    public static function getOptions(): array
    {
        return self::buildSelect(self::cases());
    }

    public static function buildSelect($options): array
    {
        return collect($options)
            ->mapWithKeys(fn($opt) => [
                $opt->value => $opt->getTranslatedLabel()
            ])
            ->toArray();
    }
}