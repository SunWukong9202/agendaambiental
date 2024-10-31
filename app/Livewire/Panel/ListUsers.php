<?php

namespace App\Livewire\Panel;

use App\Enums\Permission;
use App\Enums\Role as EnumsRole;
use App\Livewire\Panel\Traits\HandlesModelUser;
use App\Models\User;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ListUsers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use HandlesModelUser;

    public function mount(): void
    {
        $this->user = new User;
        $this->userForm->fill();   
    }

    protected function getForms(): array
    {
        return [
            'userForm',
        ];
    }

    public function save(): void
    {
        dd($this->userForm->getState());
    }

    public function table(Table $table): Table
    {
        $user = User::find(auth()->user()->id);
        return $table
            ->query(User::query())
            ->headerActions([
                CreateAction::make()
                    ->createAnother(false)
                    ->disabled(!$user->can(Permission::AddUsers->value))
                    ->model(User::class)
                    ->form($this->getUserFormSchema('mountedTableActionsData[0]'))
            ])
            ->columns([
                // Split::make([
                    TextColumn::make('key')
                        ->label(__('form.key')),
                    TextColumn::make('name')
                        ->label(__('form.name'))
                        ->searchable(),
                    TextColumn::make('email')
                        ->label(__('form.email')),
                    TextColumn::make('gender')
                        ->label(__('form.gender')),

                    SelectColumn::make('role')
                        ->disabled(!$user->can(Permission::GrantRoles->value) || !$user->can(Permission::RevokeRoles->value))
                        ->options(Role::all()->pluck('name', 'name')->map(fn ($name) => EnumsRole::readable($name)))
                        ->default(fn(User $user) => $user->roles->first()?->name)
                        ->beforeStateUpdated(function (User $record, $state) {
                            // dump($record, $state);
                            $old = $record->roles->first()?->name;
                            $record->syncRoles([$state]);
                            $action = 'assign';
                            $name = $state;
                            if(!isset($state)) {
                                $action = 'unassign';
                                $name =  $old;
                            }
                            
                            Notification::make()
                                ->success()
                                ->title(
                                    __("ui.notifications.roles.$action.title", ['name' => $name])
                                )
                                ->body(
                                    __("ui.notifications.roles.$action.body", ['name' => $name, 'user' => $record?->name])
                                )
                                ->actions([
                                    NotificationAction::make('undo')
                                        ->color('gray')
                                        ->dispatch('undo-role-assignment', [
                                            'user' => $record->id,
                                            'old' => $old
                                        ])->close()
                                ])
                                ->send();
                        })
                // ])->from('md')
                
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->record($this->user)
                    ->form($this->getUserFormSchema('mountedTableActionsData[0]')),
                
                DeleteAction::make()
                    ->label(__('form.delete'))
                    ->disabled(!$user->can(Permission::DeleteUsers->value))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    #[On('undo-role-assignment')]
    public function undoRoleAssignment(User $user, $old): void
    {
        $user?->syncRoles(
            isset($old) ? [$old] : []
        ); 
    }

    public function render()
    {
        return view('livewire.panel.list-users');
    }
}
