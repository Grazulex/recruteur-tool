<?php

namespace App\Livewire\Members;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Listing extends Component
{
    public $members;

    public function mount()
    {
        $this->members = Auth::user()->usersInMyAdminGroups();
    }

    public function render()
    {
        return view('livewire.members.listing');
    }
}
