<?php

use App\Livewire\Dashboard\Groups\Last;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Last::class)
        ->assertStatus(200);
});
