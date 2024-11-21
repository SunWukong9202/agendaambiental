<?php

namespace App\Enums;

use App\Livewire\Client\Petitions;
use Filament\Widgets\StatsOverviewWidget\Stat;

enum Movement: string {
    use Transformers;

    case Donation = 'donation';
    case Petition = 'petition';
    case Capture = 'capture';
    case Petition_By_Name = 'petition by name';
    // case Categorization = 'categorization';
    
    // case Assignment = 'assignement';
    case Reparation = 'reparation';
    //for filter purpose
    case LastRepairLog = 'last repair';

    public static function ofItems(): array
    {
        return [
            self::Capture, self::Petition, self::Petition_By_Name,
            self::Reparation,
        ];
    }

    public static function ofReagents(): array
    {
        return [
            self::Donation, self::Petition, self::Petition_By_Name
        ];
    }


    // public function action()
    // {
    //     return match ($this) {
    //         self::Repair_Started => __('Initiate reparation'),
    //         self::Repair_Log => __('Add repairment log'),
    //         self::Repair_Completed => __('Terminate repairment'),
    //         default => null
    //     };
    // }

    public function getTranslatedLabel()
    {
        return ucfirst(__($this->value));
    }

    public function getBagdeColor(): string
    {
        return match($this) {
            self::Donation => 'success',
            self::Petition => 'info',
            self::Petition_By_Name => 'indigo',
            self::Capture => 'sky',
            self::Reparation => 'gray',
        };
    }

    public function getIcon(): string
    {//deliveries => 'heroicon-m-truck'
        return match($this) {
            self::Donation => 'heroicon-m-heart',
            self::Capture => 'heroicon-m-clipboard-document-check',
            self::Petition => 'heroicon-m-gift',
            self::Petition_By_Name => 'heroicon-m-question-mark-circle',
            self::Reparation => 'heroicon-m-wrench',
            default => 'heroicon-m-rectangle-stack'
        };
    }
}