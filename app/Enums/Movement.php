<?php

namespace App\Enums;

enum Movement: string {
    case Donation = 'donation';
    case Petition = 'petition';
    case Capture = 'capture';
    case Petition_By_Name = 'petition by name';
    
    // case Categorization = 'categorization';
    case Assignment = 'assignement';
    case Repair_Started = 'repair started';
    case Repair_Completed = 'repair completed';

    /**@param string $type repairment| */
    public static function group($type = 'repairment'): array
    {
        return match($type) {
            'repairment' => [
                self::Capture, self::Assignment,
                self::Repair_Started, self::Repair_Completed
            ]
        };
    }
}