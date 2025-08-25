<?php

namespace App\Enums;

enum Condition: string 
{
    use Transformers;

    case New = 'New / Unused';
    case LikeNew = 'Like New / Excellent';
    case Good = 'Good';
    case Fair = 'Fair';
    case Poor = 'Poor';
    case Expired = 'Expired';
    case Damaged = 'Damaged / Leaking';
    case Unsuable = 'Unusable';

    public function getTranslatedLabel(): string
    {
        return __($this->value);
    }

    public static function donationOptions() : array
    {
        return [
            self::New, self::LikeNew, self::Good,
            self::Fair, self::Poor
        ];
    }
}
