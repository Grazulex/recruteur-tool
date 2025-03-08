<?php

namespace App\Livewire\Forms;

use App\Models\Group;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GroupForm extends Form
{
    #[Validate('required|string|min:3|max:255')]
    public $name = '';

    #[Validate('required|string|min:3|max:255')]
    public $description = '';

    #[Validate('required')]
    public $group_type = '';

    #[Validate('required|integer')]
    public $user_id = 0;

    public function store()
    {
        $this->validate();

        $group = Group::create($this->all());
        $group->users()->attach(auth()->user());
    }
}
