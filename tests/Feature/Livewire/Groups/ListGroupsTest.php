<?php

use App\Enums\GroupType;
use App\Livewire\Groups\Edit;
use App\Livewire\Groups\Listing;
use App\Models\User;

it('show group listing', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)->test(Listing::class)
        ->assertStatus(200)
        ->assertViewHas('groups', function ($groups) {
            return count($groups) == 1;
        })
        ->assertSee($user->groups()->first()->name)
        ->assertSee($user->groups()->first()->description)
        ->assertSee($user->groups()->first()->my_role()->getLabel())
        ->assertSee($user->groups()->first()->group_type->getLabel())
        ->assertSeeHtml('wire:click="edit('.$user->groups()->first()->id.')')
        ->assertSeeHtml('wire:click="delete('.$user->groups()->first()->id.')');
});

it('can edit a group', function () {
    $user = User::factory()->create();
    $group = $user->groups()->first();

    $group_old_name = $group->name;
    $group_new_name = 'New Group Name';

    $group_old_description = $group->description;
    $group_new_description = 'New Group Description';

    livewire::actingAs($user)->test(Edit::class)
        ->call('editGroup', $group->id)
        ->set('form.group_type', GroupType::COMPANY)
        ->set('form.name', $group_new_name)
        ->set('form.description', $group_new_description)
        ->call('update');

    livewire::actingAs($user)->test(Listing::class)
        ->assertSee($group_new_name)
        ->assertSee($group_new_description)
        ->assertDontSee($group_old_name)
        ->assertDontSee($group_old_description)
        ->assertSee($user->groups()->first()->group_type->getLabel())
        ->assertSee($user->groups()->first()->name)
        ->assertSee($user->groups()->first()->description);
});

it('can delete a group', function () {
    $user = User::factory()->create();
    $group = $user->groups()->first();

    livewire::actingAs($user)->test(Listing::class)
        ->call('delete', $group->id)
        ->call('destroy')
        ->assertStatus(200)
        ->assertViewHas('groups', function ($groups) {
            return count($groups) == 0;
        });

});
