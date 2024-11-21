<?php

namespace App\Livewire\Panel\Events;

use App\Enums\Movement;
use App\Enums\Status;
use App\Models\Pivots\ItemMovement;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use Livewire\Component;

class RepairLog extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public ItemMovement $movement;

    private function getState(): array
    {
        $logs = ItemMovement::where('group_id', $this->movement->group_id)->get()
            ->map( function ($move) {
                $data = $move->toArray();
                $status = lcfirst($move->status->getLabel());
                $data['type'] = "{$move->type->getLabel()} - {$status}"; 
                $data['created_at'] = $move->dateTime('created_at');
        
                return $data;
            });

        return [
            'logs' => $logs->toArray()
        ];
    }

    public function repairLogInfoList(Infolist $infolist): Infolist
    {
        $schema = [
            ActivityTitle::make('type'),
            ActivityDescription::make('observations'),
            ActivityDate::make('created_at')
                ->date(timezone: 'America/Mexico_City')
                ,
            
            ActivityIcon::make('status')
                ->icon(fn (string | null $state) => Status::tryFrom($state)?->getIcon())
                ->color(fn ($state) => Status::tryFrom($state)?->getBagdeColor())
        ];
        return $infolist
            ->state([
                ...$this->getState()
            ])
            ->schema([
                ActivitySection::make('logs')
                ->label('Repairment history')
                ->description('Here you can see the detailed process of repairment.')
                ->schema([
                    ...$schema
                ])
                ->showItemsCount(2) // Show up to 2 items
                ->showItemsLabel('See More') // Show "View Old" as link label
                ->showItemsIcon('heroicon-m-chevron-down') // Show button icon
                ->showItemsColor('gray') // Show button color and it supports all colors
                // ->aside(true)
                ->emptyStateHeading('No activities yet.')
                ->emptyStateDescription('Check back later for activities that have been recorded.')
                ->emptyStateIcon('heroicon-o-bolt-slash')
                ->headingVisible(true) 
            ]);
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex mb-4">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('admin.events.repairments') => __('ui.pages.Repairment Managment'),
                    '' => __('ui.log'),
                    ]"
                />
                <x-filament::loading-indicator wire:loading class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />
            </div>
                
            {{ $this->repairLogInfoList }}
            
        </div>
        HTML;
    }
}
