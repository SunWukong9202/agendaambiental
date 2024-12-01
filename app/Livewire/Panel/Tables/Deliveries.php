<?php

namespace App\Livewire\Panel\Tables;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\Waste;
use App\Models\CMUser;
use App\Enums\Permission;
use App\Livewire\Panel\Traits\HandlesDelivery;
use App\Models\Pivots\Delivery;
use App\Models\Pivots\Report;
use Carbon\Carbon;

use Livewire\Component;

class Deliveries extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use HandlesDelivery;
    private $recordCount = [];
    public $supplier;
    public $parent;

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
            ->recordClasses('hover:bg-gray-100')
            ->groups([
                Group::make('waste.category')
                    ->label(__('Waste'))
                    ->collapsible(),

                Group::make('created_at')
                    ->label(__('Date'))
                    ->getTitleFromRecordUsing(fn (Delivery $record) =>
                        Carbon::parse($record->created_at)
                            ->timezone('America/Mexico_City')
                            ->format('M d, Y h:i A')
                    )
                    ->collapsible(),
            ])
            ->headerActions([
                Action::make('edit-signature')
                    ->icon('heroicon-m-pencil-square')
                    ->label(__('Edit Signature'))
                    ->model(CMUser::class)
                    ->fillForm([
                        'signature_url' => auth()->user()->CMUser->signature_url
                    ])
                    ->modalSubmitActionLabel(__('Save'))
                    ->modalHeading(__('Edit your signature'))
                    ->form([
                        $this->getUploadSignature()
                    ])
                    ->action(function ($data, $record) {
                        $old = auth()->user()->CMUser->signature_url;

                        if(!blank($old)) Storage::disk('public')->delete($old);

                        auth()->user()->CMUser->update($data);

                        Notification::make()
                            ->success()
                            ->title(__('Saved!'))
                            ->send();
                    }),

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
                        ->searchable(),

                    TextColumn::make('event.name')
                        ->searchable(),

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
                        ),

                    TextColumn::make('user.user.name')
                        ->icon('heroicon-m-user-circle'),
                    
                    TextColumn::make('created_at')
                        ->formatStateUsing(fn (Delivery $record) => 
                            $record->dateTime('created_at')
                        ),
            ])
            ->filters([
            ])
            ->actions([
                ActionGroup::make([
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
            ])
            ->bulkActions([
                BulkAction::make('generate-pdf')
                    ->deselectRecordsAfterCompletion()
                    ->action(function ($records) {

                        $total = $records->reduce(function (?float $carry, $delivery) {
                            return $carry + $delivery->quantity;
                        }, 0.000);

                        $name = "reporte-entregas-{$this->supplier->name}-" . now('America/Mexico_City')->format('Y-m-d-H-i-s') . ".pdf";

                        // Pdf::view('pdf.deliveries', [
                        //     'from' => auth()->user(),
                        //     'to' => $this->supplier,
                        //     'deliveries' => $records,
                        //     'total' => $total,
                        // ])
                        //     ->withBrowsershot(function (Browsershot $browsershot) {
                        //         $browsershot->timeout(120);
                        //     })
                        //     ->disk('public')
                        //     ->save($url);

                        $pdfData = [
                            'from' => auth()->user(),
                            'to' => $this->supplier,
                            'deliveries' => $records,
                            'total' => $total,
                        ];

                        try {
                            
                            Pdf::view('pdf.deliveries', $pdfData)
                                ->withBrowsershot(function (Browsershot $browsershot) {
                                    $browsershot->showBrowserHeaderAndFooter();
                                })
                                ->footerView('pdf.footer')
                                ->disk('public')
                                ->save($name);

                            Report::create([
                                'cm_user_id' => auth()->user()->id,
                                'supplier_id' => $this->supplier->id,
                                'file_path' => $name,
                            ]);
        
                            Notification::make()
                            ->success()
                            ->title(__('Saved!'))
                            ->send();

                        } catch (\Exception $e) {
                            $this->onValidationError(ValidationException::withMessages([
                                __('Something went wrong, wait and try again.')
                            ]));
                        }
                            // $pdfData = [
                            //     'from_id' => auth()->user()->id,
                            //     'to_id' => $this->supplier->id,
                            //     'deliveries_ids' => $records->pluck('id'),
                            //     'total' => $total,
                            // ];

                            // ProcessPDF::dispatch($pdfData);

                    })
            ])
            ->selectCurrentPageOnly();
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    public function render()
    {
        return view('livewire.panel.tables.deliveries');
    }
}
