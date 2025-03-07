<?php

use App\Livewire\Dashboard\Groups\Last;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Last::class)
        ->assertStatus(200);
});
