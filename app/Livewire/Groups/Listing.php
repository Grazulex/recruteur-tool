<?php

namespace App\Livewire\Groups;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Listing extends Component
{
    use WithPagination;

    public $groups;

    public function mount()
    {
        $this->groups = Auth::user()->groups()->get();
    }

    public function render()
    {
        return view('livewire.groups.listing');
    }

    #[On('refresh-groups-listing')]
    public function reloadGroups()
    {
        $this->groups = Auth::user()->groups()->get();
    }
}
