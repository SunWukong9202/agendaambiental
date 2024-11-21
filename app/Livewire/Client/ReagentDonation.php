<?php

namespace App\Livewire\Client;

use App\Enums\{ChemicalContainer, ChemicalState, Condition, CRETIB, Movement, Status, Units};
use App\Models\Pivots\ReagentMovement;
use App\Models\Reagent;
use Filament\Forms\Components\{FileUpload, Section, Select, Split, Textarea, TextInput, Alert, CheckboxList, Wizard\Step};
use Filament\Forms\{Get, Set};
use Filament\Support\RawJs;

trait ReagentDonation {
    private $min_per_petition = 1.000;

    
}