<?php

namespace App\Policies;

use App\Enums\RoleUser;
use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Group $group): bool
    {
        return $group->my_role() === RoleUser::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Group $group): bool
    {
        return $group->my_role() === RoleUser::ADMIN;
    }
}
