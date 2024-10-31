<?php

namespace App\Livewire\Client;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.client')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.client.home');
    }
}
