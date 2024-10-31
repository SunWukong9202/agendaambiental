<?php

namespace App\Livewire\Panel;

use Livewire\Attributes\Validate;
use Livewire\Component;

class User extends Component
{
    #[Validate()]
    public User $user;
    public $Is_Intern = false;

    public function rules(): array
    {
        return [
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|max:80',
            'user.gender' => 'required',
        ];
    }

    public function save(): void
    {
        $this->validate()
    }

    public function render()
    {
        return view('livewire.panel.user');
    }
}
