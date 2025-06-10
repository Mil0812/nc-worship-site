<?php

namespace App\Livewire;

use App\Livewire\Actions\Logout;
use Illuminate\Foundation\Application;
use Livewire\Component;

class LogoutButton extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render(): object
    {
        return view('livewire.logout-button');
    }
}
