<?php

namespace App\Livewire\Panel\Users;

use App\Enums\Permission;
use App\Enums\Role as EnumsRole;
use App\Livewire\Panel\Traits\HandlesRoleModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndPermissions extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use HandlesRoleModel;

    public $action = 'list';

    public function mount($role = null): void
    {
        // dump($role);   
        $data = $this->setRoleData($role);
        // dump($this->roleData);
        $this->roleForm->fill($data);
    }

    public function save(): void
    {
        $data = $this->roleForm->getState();
        // dd($data);

        $name = $data['name'];
        unset($data['name']);
        $permissions = collect($data)->flatten();
        $role = Role::updateOrCreate(['name' => $name]);
        $role->syncPermissions($permissions->toArray());

        Notification::make()
            ->title(
                trans('ui.notifications.roles.success.title', [
                    'name' => $name
                ])
            )
            ->success()
            ->body(
                trans('ui.notifications.roles.success.body',[
                    'modulename' => trans('ui.pages.Admin Panel')
                ])
            )
            ->send();
            
        $this->redirectRoute('admin.roles-and-permissions');
    }

    protected function getForms(): array
    {
        return [
            'roleForm',
        ];
    }

    public function table(Table $table): Table
    {
        $user = User::find(auth()->user()->id);
        return $table
            ->query(Role::query())
            ->headerActions([
                Action::make('create')
                    ->label(__('Create role'))
                    ->url(fn () => route('admin.role.save', ['action' => 'create']))
            ])
            ->columns([
                TextColumn::make('name')
                    ->formatStateUsing(fn($state) => 
                        EnumsRole::tryFrom($state)->getTranslatedLabel()
                    )
                    ->label(__('form.name')),

                TextColumn::make('created_at')
                    ->label(__('form.created at'))
                    ->since()
                    ->dateTimeTooltip(),
                
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->disabled(!$user->can(Permission::EditRoles->value))

                    ->url(fn(Role $role) => route('admin.role.save', ['action' => 'edit', 'role' => $role->id])),
                DeleteAction::make()
                    ->disabled(fn ($record) => !$user->can(Permission::DeleteRoles->value) || in_array(EnumsRole::tryFrom($record->name), EnumsRole::cases()))

            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.panel.users.roles-and-permissions');
    }
}
