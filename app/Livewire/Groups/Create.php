<?php

namespace App\Livewire\Groups;

use App\Enums\GroupType;
use App\Livewire\Forms\GroupForm;
use Flux\Flux;
use Livewire\Component;

class Create extends Component
{
    public GroupForm $form;

    public function mount()
    {
        $this->form->group_type = GroupType::CANDIDATE;
        $this->form->user_id = auth()->user()->id;
    }

    public function render()
    {
        $groupTypes = GroupType::cases();

        return view('livewire.groups.create', [
            'groupTypes' => $groupTypes,
        ]);
    }

    public function create()
    {
        $this->form->store();

        $this->reset();

        $this->dispatch('refresh-groups-listing');

        Flux::toast(variant: 'success', heading: 'Group', text: 'Your group have been created.');

        Flux::modal('create-group')->close();

    }
}
