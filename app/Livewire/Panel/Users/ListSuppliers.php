<?php

namespace App\Livewire\Panel\Users;

use App\Enums\Permission;
use App\Livewire\Panel\Traits\HandlesDelivery;
use App\Livewire\Panel\Traits\HandlesSupplier;
use App\Models\Pivots\Delivery;
use App\Models\Supplier;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListSuppliers extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use HandlesSupplier;
    
    public function table(Table $table): Table
    {
        $user = auth()->user()->CMUser;
        return $table
            ->query(Supplier::query())
            ->recordUrl(
                fn (Supplier $record): string => route('admin.supplier.deliveries', ['supplier' => $record]),
            )
            ->headerActions([
                CreateAction::make()
                    ->label(__('ui.buttons.supplier', ['action' => __('ui.create')]))
                    ->modalHeading(__('ui.buttons.supplier', ['action' => __('ui.create')]))
                    ->createAnother(false)
                    ->disabled(!$user->can(Permission::AddSuppliers->value))
                    ->model(Supplier::class)
                    ->steps($this->getSupplierFormSchema())
                    ->successNotification(fn(Supplier $supplier) => $this->notification('created', $supplier->name)),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label(__('form.name'))
                    ->searchable(),

                TextColumn::make('tax_id')
                    ->label(__('form.tax id')),

                TextColumn::make('business_name')
                    ->label(__('form.business name')),
                
                TextColumn::make('business_activity')
                    ->label(__('form.business activity')),

                TextColumn::make('created_at')
                    ->label(__('form.created at'))
                    ->since()
                    ->dateTimeTooltip(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                    ->modalHeading(__('ui.buttons.supplier', ['action' => __('ui.edit')]))
                    ->hidden(!$user->can(Permission::EditSuppliers->value))
                    ->steps(fn(Supplier $supplier) => $this->getSupplierFormSchema($supplier))
                    ->successNotification(fn(Supplier $supplier) => $this->notification('updated', $supplier->name)),
                
                    DeleteAction::make()
                        ->modalHeading(__('ui.buttons.supplier', ['action' => __('ui.delete')]))
                        ->hidden(!$user->can(Permission::DeleteSuppliers->value))
                        ->successNotification(fn(Supplier $supplier) => $this->notification('deleted', $supplier->name))
                ])
                ->icon('heroicon-m-cursor-arrow-rays')
                ->link()
                ->label(__('Actions')),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    private function notification($action, $name): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('ui.notifications.suppliers.title', compact('action')))
            ->body(__('ui.notifications.suppliers.body', compact('action', 'name')));
    }

    // public function render()
    // {
    //     return view('livewire.panel.users.list-suppliers');
    // }
    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex mb-4">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('admin.suppliers') => __('ui.pages.Manage Suppliers'),
                    '' => __('ui.list'),
                    ]"
                />
                <x-filament::loading-indicator wire:loading class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />
            </div>
            {{ $this->table }}
        </div>
        HTML;
    }
}
