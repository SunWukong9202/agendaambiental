<?php

namespace App\Livewire\Tables;

use App\Enums\Permission;
use App\Livewire\Panel\Traits\HandlesDelivery;
use App\Models\CMUser;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent;

use App\Models\Pivots\Delivery;
use App\Models\Pivots\Report;
use App\Models\Supplier;
use App\Models\Waste;
use App\Utils\BaseTableConfiguration;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class DeliverySchema extends BaseTableConfiguration
{
    use HandlesDelivery;

    private $recordCount = [];

    public function __construct(
        //if passed we add the signature header action
        public ?CMUser $user,
        //if passed we enable the register delivery action
        public ?Supplier $supplier
    )
    {
        
    }

    public function getDefaultOptions(): array
    {
        return [
            'emptyStateHeading' => __('ui.msgs.deliveries.title'),
            'emptyStateDescription' => __('ui.msgs.deliveries.description'),
            'emptyStateIcon' => 'heroicon-m-archive-box',
            'searchPlaceholder' => __('ui.msgs.deliveries.search')
        ];
    }

    public function getDefaultColumns(): array
    {
        return [
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
        ];
    }

    public function defaultGroups(): array
    {
        return [
            Group::make('waste.category')
                ->label(__('Waste'))
                ->collapsible(),

            Group::make('created_at')
                ->label(__('Date'))
                ->getTitleFromRecordUsing(fn (Delivery $record) =>
                    $record->dateTime('created_at')
                )
                ->collapsible(),
        ];
    }

    public function defaultHeaderActions(): array
    {
        return [
            'edit-signature' => $this->user != null
                ? $this->getSignatureAction()
                : null, //<= the base remove all entries with null value,
            
            'register-delivery' => $this->supplier != null
                ? $this->getRegisterDeliveryAction()
                : null
        ];
    }

    protected function getRegisterDeliveryAction(): CreateAction
    {
        return CreateAction::make()
            ->label(__('Register Delivery'))
            ->modalHeading(__('Register Delivery'))
            ->icon('heroicon-m-archive-box')
            ->model(Delivery::class)
            ->createAnother(false)
            ->form($this->getDeliverySchema())
            ->mutateFormDataUsing(function ($data) {
                $data['cm_user_id'] = $this->user->id;
                $data['supplier_id'] = $this->supplier->id;

                return $data;
            })
            ->successNotification(fn(Delivery $record) =>
                $this->deliveryNotification(
                    'registered',
                    $record
                )
            );
    }

    protected function getSignatureAction(): Action
    {
        return Action::make('edit-signature')
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
            });
    }

    public function getDefaultFilters(): array
    {
        return [

        ];
    }

    public function getDefaultActions(): array
    {
        $user = $this->user ?? auth()->user()->CMUser;

        return [
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
        ];
    }

    public function getDefaultBulkActions(): array
    {
        return [
            'generate-pdf' => $this->supplier != null
                ? $this->getGeneratePdf()
                : null
        ];
    }

    protected function getGeneratePdf(): BulkAction
    {
        return BulkAction::make('generate-pdf')
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

        });
    }
}
