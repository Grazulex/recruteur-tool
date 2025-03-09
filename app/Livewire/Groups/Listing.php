<?php

namespace App\Livewire\Groups;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Listing extends Component
{
    use WithPagination;

    public $groups;

    private $user;

    public function mount()
    {
        $this->user = User::find(Auth::user()->id);
        $this->groups = $this->user->groups()->get();
    }

    public function render()
    {
        return view('livewire.groups.listing');
    }

    #[On('refresh-groups-listing')]
    public function reloadGroups()
    {
        $this->user = User::find(Auth::user()->id);
        $this->groups = $this->user->groups()->get();
    }
}
