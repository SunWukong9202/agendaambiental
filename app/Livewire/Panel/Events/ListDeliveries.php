<?php

namespace App\Livewire\Panel\Events;

use App\Models\Supplier;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Livewire\Tables\DeliverySchema;

class ListDeliveries extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Supplier $supplier;
    #[Url()]
    public $tab = 'deliveries';

    public function table(Table $table): Table
    {
        $user = auth()->user()->CMUser;

        $table = (new DeliverySchema($user, $this->supplier))
            ->configure($table);

        return $table
            ->relationship(fn () => $this->supplier->deliveries());
    }

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
        
            <div class="mb-8 mx-auto max-w-4xl flex justify-center">
                <x-filament::tabs 
                    custom-scrollbar="x-sm"
                >
                    @php
                        $move = \App\Enums\Movement::class;
                    @endphp

                    <x-filament::tabs.item
                        class="shrink-0"
                        icon="heroicon-o-truck"
                        :active="$tab === 'deliveries'"
                        wire:click="$set('tab', 'deliveries')"
                    >
                        {{ __('Deliveries') }}
                    </x-filament::tabs.item>

                    <x-filament::tabs.item
                        class="shrink-0"
                        icon="heroicon-o-document-chart-bar"
                        :active="$tab === 'reports'"
                        wire:click="$set('tab', 'reports')"
                    >
                        {{ __('Reports') }}
                    </x-filament::tabs.item>                
                </x-filament::tabs>
            </div>        

            @if($tab == 'deliveries')
                {{ $this->table }}
            @else
                @livewire('panel.events.list-reports', ['supplier' => $supplier])
            @endif
        </div>
        HTML;
    }
}

    // public function render()
    // {
    //     return view('livewire.panel.events.list-deliveries');
    // }


// public function table(Table $table): Table
// {   //quantity, waste_id,cm_user_id,supplier_id,event_id
//     $user = auth()->user()->CMUser;
//     return $table
//         ->relationship(fn () => $this->supplier->deliveries())
//         ->inverseRelationship('supplier')
//         ->emptyStateHeading(__('ui.msgs.deliveries.title'))
//         ->emptyStateDescription(__('ui.msgs.deliveries.description'))
//         ->emptyStateIcon(fn () => __('ui.msgs.deliveries.icon'))
//         ->searchPlaceholder(__('ui.msgs.deliveries.search'))
//         ->recordClasses('hover:bg-gray-100')
//         ->groups([
//             Group::make('waste.category')
//                 ->label(__('Waste'))
//                 ->collapsible(),

//             Group::make('created_at')
//                 ->label(__('Date'))
//                 ->getTitleFromRecordUsing(fn (Delivery $record) =>
//                     Carbon::parse($record->created_at)
//                         ->timezone('America/Mexico_City')
//                         ->format('M d, Y h:i A')
//                 )
//                 ->collapsible(),
//         ])
//         ->headerActions([
//             Action::make('edit-signature')
//                 ->icon('heroicon-m-pencil-square')
//                 ->label(__('Edit Signature'))
//                 ->model(CMUser::class)
//                 ->fillForm([
//                     'signature_url' => auth()->user()->CMUser->signature_url
//                 ])
//                 ->modalSubmitActionLabel(__('Save'))
//                 ->modalHeading(__('Edit your signature'))
//                 ->form([
//                     $this->getUploadSignature()
//                 ])
//                 ->action(function ($data, $record) {
//                     $old = auth()->user()->CMUser->signature_url;

//                     if(!blank($old)) Storage::disk('public')->delete($old);

//                     auth()->user()->CMUser->update($data);

//                     Notification::make()
//                         ->success()
//                         ->title(__('Saved!'))
//                         ->send();
//                 }),

//             CreateAction::make()
//                 ->label(__('Register Delivery'))
//                 ->modalHeading(__('Register Delivery'))
//                 ->icon('heroicon-m-archive-box')
//                 ->model(Delivery::class)
//                 ->createAnother(false)
//                 ->form($this->getDeliverySchema())
//                 ->mutateFormDataUsing(function ($data) use ($user) {
//                     $data['cm_user_id'] = $user->id;
//                     $data['supplier_id'] = $this->supplier->id;

//                     return $data;
//                 })
//                 ->successNotification(fn(Delivery $record) =>
//                     $this->deliveryNotification(
//                         'registered',
//                         $record
//                     )
//                 )
//                 ,
//         ])
//         ->columns([
//             TextColumn::make('waste.category')
//                     ->searchable(),

//                 TextColumn::make('event.name')
//                     ->searchable(),

//                 TextColumn::make('quantity')
//                     ->tooltip(fn(Delivery $record) => Waste::find($record->waste_id)?->category)
//                     ->formatStateUsing(function (Delivery $record, $state) {
//                         $waste = Waste::find($record->waste_id);

//                         return "$state {$waste->unit}";
//                     })
//                     ->summarize(Summarizer::make()
//                         ->label(__('Total'))
//                         ->using(function (Builder $query) {
//                             $record = $query->first();
//                             $waste = Waste::find($record->waste_id);
//                             $sum = $query->sum('quantity');
//                             $this->recordCount[] = $query->count();
//                             return "$sum {$waste->unit}";
//                         })
//                         ->hidden(fn (?Eloquent\Builder $query) => !($query?->exists() ?? true))
//                     ),

//                 TextColumn::make('user.user.name')
//                     ->icon('heroicon-m-user-circle'),
                
//                 TextColumn::make('created_at')
//                     ->formatStateUsing(fn (Delivery $record) => 
//                         $record->dateTime('created_at')
//                     ),
//         ])
//         ->filters([
//         ])
//         ->actions([
//             ActionGroup::make([
//                 EditAction::make()
//                 ->modalHeading(__('Edit delivery'))
//                 ->hidden(!$user->can(Permission::EditDeliveries->value))
//                 ->form(fn(Delivery $record) => $this->getDeliverySchema($record))
//                 ->successNotification(fn(Delivery $record) =>
//                     $this->deliveryNotification(
//                         'updated',
//                         $record
//                     )
//                 ),

//                 DeleteAction::make()
//                     ->successNotification(fn(Delivery $record) =>
//                         $this->deliveryNotification(
//                             'deleted',
//                             $record
//                         )
//                     ),
//             ])
//         ])
//         ->bulkActions([
//             BulkAction::make('generate-pdf')
//                 ->deselectRecordsAfterCompletion()
//                 ->action(function ($records) {

//                     $total = $records->reduce(function (?float $carry, $delivery) {
//                         return $carry + $delivery->quantity;
//                     }, 0.000);

//                     $name = "reporte-entregas-{$this->supplier->name}-" . now('America/Mexico_City')->format('Y-m-d-H-i-s') . ".pdf";

//                     // Pdf::view('pdf.deliveries', [
//                     //     'from' => auth()->user(),
//                     //     'to' => $this->supplier,
//                     //     'deliveries' => $records,
//                     //     'total' => $total,
//                     // ])
//                     //     ->withBrowsershot(function (Browsershot $browsershot) {
//                     //         $browsershot->timeout(120);
//                     //     })
//                     //     ->disk('public')
//                     //     ->save($url);

//                     $pdfData = [
//                         'from' => auth()->user(),
//                         'to' => $this->supplier,
//                         'deliveries' => $records,
//                         'total' => $total,
//                     ];

//                     try {
                        
//                         Pdf::view('pdf.deliveries', $pdfData)
//                             ->withBrowsershot(function (Browsershot $browsershot) {
//                                 $browsershot->showBrowserHeaderAndFooter();
//                             })
//                             ->footerView('pdf.footer')
//                             ->disk('public')
//                             ->save($name);

//                         Report::create([
//                             'cm_user_id' => auth()->user()->id,
//                             'supplier_id' => $this->supplier->id,
//                             'file_path' => $name,
//                         ]);
    
//                         Notification::make()
//                         ->success()
//                         ->title(__('Saved!'))
//                         ->send();

//                     } catch (\Exception $e) {
//                         $this->onValidationError(ValidationException::withMessages([
//                             __('Something went wrong, wait and try again.')
//                         ]));
//                     }
//                         // $pdfData = [
//                         //     'from_id' => auth()->user()->id,
//                         //     'to_id' => $this->supplier->id,
//                         //     'deliveries_ids' => $records->pluck('id'),
//                         //     'total' => $total,
//                         // ];

//                         // ProcessPDF::dispatch($pdfData);

//                 })
//         ])
//         ->selectCurrentPageOnly();
// }