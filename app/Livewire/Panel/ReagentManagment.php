<?php

namespace App\Livewire\Panel;

use App\Livewire\Tables\ReagentCRUDSchema;
use App\Models\Reagent;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ReagentManagment extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        $table = (new ReagentCRUDSchema)
            ->configure($table);

        return $table
            ->query(Reagent::query());
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex mb-4">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('admin.reagents.managment') => __('ui.pages.Manage Reagents'),
                    '' => __('ui.list'),
                    ]"
                />
            </div>

            {{ $this->table }}
        </div>
        HTML;
    }
}
