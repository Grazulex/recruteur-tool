<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Enums\GroupType;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

class GroupForm extends Form
{
    public $name = '';

    public $description = '';

    public $group_type = '';

    public $user_id = 0;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:255',
            'group_type' => ['required', Rule::enum(GroupType::class)],
            'user_id' => 'required|exists:App\Models\User,id',
        ];
    }

    public function store()
    {
        $this->validate();

        $group = Group::create($this->all());
        $group->users()->attach(Auth::user());
    }
}
