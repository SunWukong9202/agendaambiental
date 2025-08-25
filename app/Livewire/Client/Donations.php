<?php

namespace App\Livewire\Client;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.client')]
class Donations extends Component
{
    public function render()
    {
        return view('livewire.client.donations');
    }
}
