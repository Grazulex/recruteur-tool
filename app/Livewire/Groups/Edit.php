<?php

declare(strict_types=1);

namespace App\Livewire\Groups;

use App\Enums\GroupType;
use App\Livewire\Forms\GroupForm;
use App\Models\Group;
use Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public Group $group;

    public GroupForm $form;

    public function render()
    {
        $groupTypes = GroupType::cases();

        return view(
            view: 'livewire.groups.edit',
            data: [
                'groupTypes' => $groupTypes,
            ]
        );
    }

    #[On('edit-group')]
    public function editGroup(int $id)
    {
        $this->group = Group::find($id);

        $this->authorize('update', $this->group);

        $this->form->fill($this->group);

        Flux::modal('edit-group')->show();
    }

    public function update()
    {
        $this->form->update($this->group);

        $this->reset();

        $this->dispatch('refresh-groups-listing');

        Flux::toast(variant: 'success', heading: 'Group', text: 'Your group have been updated.');

        Flux::modal('edit-group')->close();
    }
}
