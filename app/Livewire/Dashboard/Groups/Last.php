<?php

namespace App\Livewire\Dashboard\Groups;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Last extends Component
{
    public $groups;

    public function mount()
    {
        $this->groups = Group::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.dashboard.groups.last');
    }
}
