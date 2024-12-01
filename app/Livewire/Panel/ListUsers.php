<?php

namespace App\Livewire\Panel;

use App\Enums\Permission;
use App\Enums\Role as EnumsRole;
use App\Livewire\Panel\Traits\HandlesModelUser;
use App\Models\CMUser;
use App\Models\User;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Enums\FiltersLayout;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ListUsers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use HandlesModelUser;
    #[Url(as: 'only-externs')]
    public $tab = false;

    public function mount(): void
    {
        $this->user = new CMUser;
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

    public function updatedTab(): void
    {
        $this->resetTable();
    }

    public function getQuery()
    {
        $query = CMUser::query();
        
        return $this->tab
            ? $query->whereNull('user_id')
            : $query->whereNotNull('user_id');
    }

    public function table(Table $table): Table
    {
        $user = auth()->user()->CMUser;
        return $table
            ->query($this->getQuery())
            ->headerActions([
                EditAction::make()
                ->label(__('Edit Signature'))
                ->record(auth()->user()->CMUser)
                ->modalHeading(__('Edit your signature'))
                ->form([
                    $this->getUploadSignature()
                ]),

                CreateAction::make()
                    ->label(__('ui.buttons.user', ['action' => __('ui.create')]))
                    ->modalHeading(__('ui.buttons.user', ['action' => __('ui.create')]))
                    ->createAnother(false)
                    ->hidden(!$this->tab || !$user?->can(Permission::AddUsers->value))
                    ->model(CMUser::class)
                    ->form($this->getUserFormSchema())
                    ->mutateFormDataUsing(function ($data) {
                        if(isset($data['other_gender'])) {
                            $data['gender'] = $data['other_gender'];
                            unset($data['other_gender']);
                        }
                        return $data;
                    })
                    ->successNotification(fn(CMUser $user) => $this->notification('created', $user->name))
            ])
            ->columns([
                // Split::make([

                    TextColumn::make($this->getColumnPath('key'))
                        ->hidden($this->tab)
                        ->label(__('form.key'))
                        ->searchable(),
                    TextColumn::make($this->getColumnPath('name'))
                        ->label(__('form.name'))
                        ->searchable(),
                    TextColumn::make($this->getColumnPath('email'))
                        ->label(__('form.email'))
                        ->searchable(),

                    TextColumn::make($this->getColumnPath('gender'))
                        ->label(__('form.gender'))
                        ->formatStateUsing(function ($state) {
                            if(collect(trans('form.genders'))->has($state)) {
                                return __("form.genders.$state");
                            } 
                            return $state;
                        }),

                    TextColumn::make('created_at')
                        ->label(__('form.created at'))
                        ->hidden(!$this->tab)
                        ->since()
                        ->dateTimeTooltip(),

                    SelectColumn::make('role')
                        ->hidden($this->tab)
                        ->disabled(!$user->can(Permission::GrantRoles->value) || !$user->can(Permission::RevokeRoles->value))
                        ->options(Role::all()->pluck('name', 'name')->map(fn ($name) => EnumsRole::readable($name)))
                        ->default(fn(CMUser $user) => $user->roles->first()?->name)
                        ->beforeStateUpdated(function (CMUser $record, $state) {
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
                                    __("ui.notifications.roles.$action.body", ['name' => $name, 'user' => $record->user?->name])
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
            ->actions([
                EditAction::make()
                    ->modalHeading(__('ui.buttons.user', ['action' => __('ui.edit')]))
                    ->hidden(fn(CMUser $CMUser) => isset($CMUser->user_id) || !$user->can(Permission::DeleteUsers->value))
                    ->form(fn(CMUser $user) => $this->getUserFormSchema($user))
                    ->mutateRecordDataUsing(function ($data) {
                        // dd($data);
                        if(!collect(trans('form.genders'))->has($data['gender'])) {
                            $data['other_gender'] = $data['gender'];
                            $data['gender'] = 'other';
                        }
                        return $data;
                    })
                    ->successNotification(fn(CMUser $user) => $this->notification('updated', $user->name)),
                
                DeleteAction::make()
                    ->modalHeading(__('ui.buttons.user', ['action' => __('ui.delete')]))
                    ->label(__('ui.delete'))
                    ->hidden(fn(CMUser $CMUser) => isset($CMUser->user_id) || !$user->can(Permission::DeleteUsers->value))
                    ->successNotification(fn(CMUser $user) => $this->notification('deleted', $user->name))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    private function notification($action, $name): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('ui.notifications.users.title', compact('action')))
            ->body(__('ui.notifications.users.body', compact('action', 'name')));
    }

    public function getColumnPath($attribute): string
    {
        return $this->tab ? $attribute : "user.$attribute";
    }

    #[On('undo-role-assignment')]
    public function undoRoleAssignment(CMUser $user, $old): void
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
