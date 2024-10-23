<?php

namespace App\Livewire\Panel;

use App\Models\User;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListUsers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->headerActions([
                CreateAction::make()
                    ->model(User::class)
                    ->form([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                    ])
            ])
            ->columns([
                // Split::make([
                    TextColumn::make('key')
                        ->label(__('form.key')),
                    TextColumn::make('name')
                        ->label(__('form.name')),
                    TextColumn::make('email')
                        ->label(__('form.email')),
                    TextColumn::make('gender')
                        ->label(__('form.gender')),
                // ])->from('md')
                
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // Action::make('edit')
                //     ->url(fn (User $user): string => route('users.edit', $user)),
                
                Action::make('delete')
                    ->label(__('form.delete'))
                    ->requiresConfirmation()
                    ->action(fn (User $record) => $record->delete())
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.panel.list-users');
    }
}
