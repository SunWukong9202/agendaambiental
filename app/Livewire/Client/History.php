<?php

namespace App\Livewire\Client;

use App\Enums\Movement;
use App\Models\Pivots\ItemMovement;
use App\Models\Pivots\ReagentMovement;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class History extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public $tab;
    public $forReagents = false;
    
    public function mount()
    {
        $this->tab = Movement::Petition->value;
    }

    private function getQuery()
    {
        $move = Movement::tryFrom($this->tab);

        $qItem = ItemMovement::query()
            ->where('cm_user_id', auth()->user()->CMUser->id)
            ->where('type', $move);
        
        $qRea = ReagentMovement::query()
            ->where('cm_user_id', auth()->user()->CMUser->id)
            ->where('type', $move);

        return $this->forReagents ? $qRea : $qItem;
        
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->columns([
                TextColumn::make('name'),
            ])
            ->actions([
                // ...
            ]);
    }

    private function getDonationColumns(): array
    {
        return [

        ];
    }

    private function getPetitionColumns(): array
    {
        $status = TextColumn::make('status')
            ->badge()
            ->icon(fn($state) => $state->getIcon())
            ->color(fn ($state) => $state->getBagdeColor());

        return $this->forReagents ? [
            TextColumn::make('')
        ] : [
            
        ];
    }

    public function render()
    {
        return view('livewire.client.history');
    }
}
