<?php

namespace App\Livewire\Panel\Events;

use App\Enums\Permission;
use App\Livewire\Panel\Traits\HandlesDelivery;
use App\Models\CMUser;
use App\Models\Event;
use App\Models\Pivots\Delivery;
use App\Models\Supplier;
use App\Models\Waste;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Livewire\Component;

class ListDeliveries extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use HandlesDelivery;

    public Supplier $supplier;
    public $recordCount = [];

    public function mount()
    {
        // $this->supplier = Supplier::find(1) ?? new Supplier;
    }
    
    public function table(Table $table): Table
    {   //quantity, waste_id,cm_user_id,supplier_id,event_id
        $user = auth()->user()->CMUser;
        return $table
            ->relationship(fn () => $this->supplier->deliveries())
            ->inverseRelationship('supplier')
            ->emptyStateHeading(__('ui.msgs.deliveries.title'))
            ->emptyStateDescription(__('ui.msgs.deliveries.description'))
            ->emptyStateIcon(fn () => __('ui.msgs.deliveries.icon'))
            ->searchPlaceholder(__('ui.msgs.deliveries.search'))
            ->groups([
                Group::make('waste.category')
                    ->label(__('Waste'))
                    // ->orderQueryUsing(fn (Eloquent\Builder $query, $direction) => $query
                    //     ->orderBy('waste_id', $direction)
                    //     ->orderBy('created_at', $direction)
                    // )
                    // ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('status', $direction)
                    ->collapsible(),
                
                Group::make('created_at')
                    ->label(__('Date'))
                    ->getTitleFromRecordUsing(fn (Delivery $record) => 
                        Carbon::parse($record->created_at)
                            ->timezone('America/Mexico_City')
                            ->format('M d, Y h:i A')
                    )
                    // ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('status', $direction)
                    ->collapsible(),
            ])
            ->defaultGroup('waste.category')
            ->headerActions([
                CreateAction::make()
                    ->label(__('Register Delivery'))
                    ->modalHeading(__('Register Delivery'))
                    ->icon('heroicon-m-archive-box')
                    ->model(Delivery::class)
                    ->createAnother(false)
                    ->form($this->getDeliverySchema())
                    ->mutateFormDataUsing(function ($data) use ($user) {
                        $data['cm_user_id'] = $user->id;
                        $data['supplier_id'] = $this->supplier->id;

                        return $data;
                    })
                    ->successNotification(fn(Delivery $record) => 
                        $this->deliveryNotification(
                            'registered',
                            $record
                        )
                    )
                    ,
            ])
            ->columns([
                TextColumn::make('waste.category')
                        ->searchable()
                        ->extraAttributes([
                            'class' => 'hidden'
                        ])->grow(false),

                Split::make([

                    TextColumn::make('event.name')
                        ->searchable(),

                    Stack::make([
                        // TextColumn::make('waste.category')
                        //     ->visible(!$this->wasteGroupActive),
                            
                        TextColumn::make('quantity')
                            ->tooltip(fn(Delivery $record) => Waste::find($record->waste_id)?->category)
                            ->formatStateUsing(function (Delivery $record, $state) {
                                $waste = Waste::find($record->waste_id);

                                return "$state {$waste->unit}";
                            })
                            ->summarize(Summarizer::make()
                                ->label(__('Total'))
                                ->using(function (Builder $query) {
                                    $record = $query->first();
                                    $waste = Waste::find($record->waste_id);
                                    $sum = $query->sum('quantity');
                                    $this->recordCount[] = $query->count();
                                    return "$sum {$waste->unit}";
                                })
                                ->hidden(fn (?Eloquent\Builder $query) => !($query?->exists() ?? true))
                            )
                            ,
                        //nov day, year time
                        TextColumn::make('created_at')
                            ->dateTime('M d, Y h:i A', 'America/Mexico_City'),
                    ]),

                    Stack::make([
                        TextColumn::make('cm_user_id')
                            ->formatStateUsing(fn() => 'Deliver By')
                            ->badge(),
                        TextColumn::make('cm_user_id')
                            ->formatStateUsing(function ($state) {
                                $user = CMUser::find($state);

                                return $user?->name ?? $user?->user->name; 
                            })->icon('heroicon-m-user-circle')
                            ->tooltip(__(''))
                    ])->space(2),

                ])->from('md'),
            ])
            ->filters([
                QueryBuilder::make()
                    ->Constraints([
                        DateConstraint::make('created_at'),
                    ])
            ])
            ->actions([
                EditAction::make()
                    ->modalHeading(__('Edit delivery'))
                    ->hidden(!$user->can(Permission::EditDeliveries->value))
                    ->form(fn(Delivery $record) => $this->getDeliverySchema($record))
                    ->successNotification(fn(Delivery $record) => 
                        $this->deliveryNotification(
                            'updated',
                            $record
                        )
                    ),

                DeleteAction::make()
                    ->successNotification(fn(Delivery $record) => 
                        $this->deliveryNotification(
                            'deleted',
                            $record
                        )
                    ),

            ])
            ->bulkActions([
                // ...
            ]);
    }

    // public function render()
    // {
    //     return view('livewire.panel.events.list-deliveries');
    // }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex mb-2">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('admin.suppliers') => __('ui.pages.Manage Suppliers'),
                    '' => __('ui.deliveries'),
                    ]"
                />
                <x-filament::loading-indicator wire:loading class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />
            </div>
            <h1 class="font-bold mb-4 leading-snug tracking-tight bg-gradient-to-tr from-gray-800 to-gray-500 bg-clip-text text-transparent mx-auto w-full text-xl lg:max-w-2xl lg:text-3xl">
                {{ $supplier?->name }}
            </h1>
            {{ $this->table }}
        </div>
        HTML;
    }
}
