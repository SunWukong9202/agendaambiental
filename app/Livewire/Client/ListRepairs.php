<?php

namespace App\Livewire\Client;

use App\Enums\Movement;
use App\Enums\Status;
use App\Forms\Components\Alert;
use App\Livewire\DBNotifications;
use App\Livewire\Panel\Traits\HandlesItem;
use App\Livewire\Panel\Traits\HandlesItemMovement;
use App\Models\CMUser;
use App\Models\Pivots\ItemMovement;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.client')]
class ListRepairs extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    //use HandlesItemMovement;
    //use DBNotifications;
    use HandlesItem;

    public ?CMUser $user = null;

    public function mount(): void
    {
        $this->user = auth()->user()->CMUser;
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn() => $this->user
                ->repairments()
                ->whereIn('status', [
                    Status::Assigned,
                ])
            )
            ->recordClasses('opacity-30')
            ->searchPlaceholder(__('Search by item/asignator name'))
            ->columns([
                Stack::make([
                    Split::make([
                        TextColumn::make('item.name')
                            ->searchable()
                            ->weight(FontWeight::SemiBold)
                            ->size(TextColumnSize::Medium),
                        
                        // TextColumn::make('group_id')
                        //     ->badge()
                        //     ->alignment(Alignment::End)
                        //     ->formatStateUsing(fn($state) => $this->get(Movement::LastRepairLog, $state)->first()?->status->getLabel())
                        //     ->icon(fn($state) => $this->get(Movement::LastRepairLog, $state)->first()?->status->getIcon())
                        //     ->color(fn ($state) => $this->get(Movement::LastRepairLog, $state)->first()?->status->getBagdeColor())
                        //     ->suffix(function ($state) {
                        //         $count = $this->get(Movement::Repa, $state)->count();
                        //         $isLog = $this->get(Movement::LastRepairLog, $state)->first()->type == Movement::Repair_Log;

                        //         return $isLog && $count > 0 
                        //         ? new HtmlString("<span class='  bg-white dark:bg-gray-800 rounded-full inline-block ml-2 p-1'>{$count}</span>")
                        //         : '';

                        //     })->html(),
                            
                    ]),

                    Stack::make([

                        TextColumn::make('user.user.name')
                            ->label(__('Assigned by'))
                            ->searchable(),
                        
                        Split::make([
                            TextColumn::make('status')
                            ->badge()
                            ->icon(fn($state) => $state->getIcon())
                            ->color(fn ($state) => $state->getBagdeColor()),

                            TextColumn::make('created_at')
                            ->label(__('Assigned'))
                            ->formatStateUsing(fn(ItemMovement $record) => $record->dateTime('created_at'))
                            ->alignment(Alignment::End)
                            ->verticalAlignment(VerticalAlignment::End)
                        ]),

                    ])->space(2)
                    ->extraAttributes(['class' => 'px-4 pb-4 -mx-4 border-b']),
                ])
                ->space(2)   
            ])
            ->contentGrid([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->actions([

                $this->getLogCommentableAction()
                    ->record(fn(ItemMovement $record) => $record),
            
            ]);
    }

    public function writeLog()
    {
        return CreateAction::make('write-log')
            ->form([
                TextInput::make('title'),
                Textarea::make('body'),
            ]);
    }

    private function get(Movement $movement, $by, ?Status $with = null)
    {
        $query = $this->user?->repairments()
            ->where('group_id', $by);

        if($movement == Movement::LastRepairLog) {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->where('type', $movement);
        }

        if($with) {
            $query->where('status', $with);
        }

        return $query;
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            {{ $this->table }}
        </div>
        HTML;
    }
}



// ReplicateAction::make('repair-started')
// ->visible(fn(ItemMovement $record) => 
//     !$this->get(Movement::Repair_Started, by: $record->group_id)->first() &&
//     !$this->get(Movement::Assignment, by: $record->group_id, with: Status::Unassigned)->first()
// )
// ->label(Movement::Repair_Started->action())
// ->modalHeading(Movement::Repair_Started->action())
// ->modalSubmitActionLabel(Movement::Repair_Started->action())
// ->successNotificationTitle(__('Saved!'))
// ->record(fn(ItemMovement $record) => $record)
// ->mutateRecordDataUsing(function ($data) {
//     $data['observations'] = '';

//     return $data;
// })
// ->form($this->getRepaimentSchema(Movement::Repair_Started)),

// ActionGroup::make([
// ReplicateAction::make('repair-log')
// ->label(Movement::Repair_Log->action())
// ->modalHeading(Movement::Repair_Log->action())
// ->modalSubmitActionLabel(Movement::Repair_Log->action())
// ->icon('heroicon-m-clipboard-document-list')
// ->successNotificationTitle(__('Saved!'))
// ->mutateRecordDataUsing(function ($data) {
//     $data['observations'] = '';

//     return $data;
// })
// ->form($this->getRepaimentSchema(Movement::Repair_Log)),

// ReplicateAction::make('repair-completed')
//     ->label(Movement::Repair_Completed->action())
//     ->modalHeading(Movement::Repair_Completed->action())
//     ->icon('heroicon-m-wrench')
//     ->successNotificationTitle(__('Saved!'))
//     ->modalSubmitActionLabel(Movement::Repair_Completed->action())
//     ->mutateRecordDataUsing(function ($data) {
//         $data['observations'] = '';

//         return $data;
//     })
//     ->form($this->getRepaimentSchema(Movement::Repair_Completed)),
// ])
// ->icon('heroicon-m-plus')
// ->link()
// ->label(__('Add repairment'))
// ->record(fn(ItemMovement $record) => $record)
// ->visible(fn(ItemMovement $record) => 
// $this->get(Movement::Repair_Started, by: $record->group_id)->first() &&
// !$this->get(Movement::Repair_Completed, $record->group_id)->first()
// )