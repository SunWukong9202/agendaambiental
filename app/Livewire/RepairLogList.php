<?php

namespace App\Livewire;

use App\Enums\Movement;
use App\Enums\Status;
use App\Models\CMUser;
use App\Models\Pivots\ItemMovement;
use Filament\Forms\Components\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use Livewire\Component;

class RepairLogList extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public ItemMovement $movement;
    public $withBreadcrumb = true;

    private function getGroup()
    {
        return ItemMovement::where('group_id', $this->movement->group_id);
    }

    public function hasBeenUnassigned()
    {
        $move = $this->getGroup()->where('status', Status::Unassigned)
            ->first();

        return $move;
    }

    private function getState(): array
    {
        $logs = $this->getGroup()
            ->with('related:id,user_id', 'related.user:id,name,email')
            ->get()
            ->map( function ($move) {
                $data = $move->toArray();
                $status = lcfirst($move->status->getTranslatedLabel());
                $data['type'] = "{$move->type->getTranslatedLabel()} - {$status}";
                $name = $move->related->user->name;
                $hint = $move->related->id == auth()->user()->CMUser->id
                    ? "(" . __('You') . ")"
                    : ''; 
                    
                $username = match($move->status) {
                    Status::Unassigned, Status::RepairLog => " " . __('from') . " $name $hint", 
                    Status::Assigned => " " . __('to') . " $name $hint",
                    default => ''
                };

                $data['type'] .= $username;
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
        return view('livewire.repair-log-list');
    }
}
