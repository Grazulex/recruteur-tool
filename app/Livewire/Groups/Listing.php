<?php

namespace App\Livewire\Groups;

use App\Models\Group;
use App\Models\User;
use Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Listing extends Component
{
    use WithPagination;

    public $groups;

    private $user;

    public Group $group;

    public function mount()
    {
        $this->user = User::find(Auth::user()->id);
        $this->groups = $this->user->groups()->withCount('users')->get();
    }

    public function render()
    {
        return view('livewire.groups.listing');
    }

    #[On('refresh-groups-listing')]
    public function reloadGroups()
    {
        $this->user = User::find(Auth::user()->id);
        $this->groups = $this->user->groups()->withCount('users')->get();
    }

    public function edit(int $id)
    {
        $this->group = Group::find($id);
        $this->authorize('update', $this->group);
        $this->dispatch('edit-group', $id);
    }

    public function delete(int $id)
    {
        $this->group = Group::find($id);
        $this->authorize('delete', $this->group);
        Flux::modal('delete-group')->show();
    }

    public function destroy()
    {
        $this->group->delete();

        $this->reloadGroups();

        Flux::toast(variant: 'success', heading: 'Group', text: 'Your group have been deleted.');

        Flux::modal('delete-group')->close();
    }
}
