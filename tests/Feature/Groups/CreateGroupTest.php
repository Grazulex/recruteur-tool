<?php

use App\Enums\GroupType;
use App\Models\Group;
use App\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test("can create group", function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $group = Group::factory()->create([
        "name"=> "Admin_test",
        "description"=> "Administrators group",
        "user_id"=> $user->id,
        "group_type" => GroupType::AGENCY,
    ]);

    expect($group->name)->toEqual("Admin_test");
    expect($group->description)->toEqual("Administrators group");
    expect($group->user_id)->toEqual($user->id);
    expect($group->slug)->toEqual("admin-test");
    expect($group->group_type)->toEqual(GroupType::AGENCY);
});

test("create group with same slug", function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $group = Group::create([
        "name"=> "Admin_test",
        "description"=> "Administrators group",
        "user_id"=> $user->id,
    ]);

    $group2 = Group::create([
        "name"=> "Admin_test",
        "description"=> "Administrators group",
        "user_id"=> $user->id,
    ]);

    $group3 = Group::create([
        "name"=> "Admin_test",
        "description"=> "Administrators group",
        "user_id"=> $user->id,
    ]);

    $group4 = Group::create([
        "name"=> "Admin_test_1",
        "description"=> "Administrators group",
        "user_id"=> $user->id,
    ]);

    expect($group->slug)->toEqual("admin-test");
    expect($group2->slug)->toEqual("admin-test-1");
    expect($group3->slug)->toEqual("admin-test-2");
    expect($group4->slug)->toEqual("admin-test-3");
});