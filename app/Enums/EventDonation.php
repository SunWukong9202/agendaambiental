<?php

namespace App\Enums;

enum EventDonation: int {
    use Transformers;

    case Books = 0;
    case Waste = 1;

    public function getTranslatedLabel(): string
    {
        return __($this->name);
    }

    public function getIcon(): string
    {
        return match($this) {
            self::Books => 'heroicon-m-book-open',
            self::Waste => 'heroicon-m-square-3-stack-3d'
        };
    }

    public function getBadgeColor(): string
    {
        return match($this) {
            self::Books => 'gray',
            self::Waste => 'warning'
        };
    }
}