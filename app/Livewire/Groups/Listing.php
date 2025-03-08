<?php

namespace App\Livewire\Groups;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Listing extends Component
{
    use WithPagination;

    public function render()
    {
        $groups = Auth::user()->groups()->paginate(10);

        return view('livewire.groups.listing', compact('groups'));

    }
}
