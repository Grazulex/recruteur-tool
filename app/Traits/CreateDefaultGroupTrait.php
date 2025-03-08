<?php

namespace App\Traits;

use App\Enums\GroupType;
use App\Enums\RoleUser;
use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait CreateDefaultGroupTrait
{
    public static function bootCreateDefaultGroupTrait(): void
    {
        static::created(function (Model $model) {
            $model->createDefaultGroup();
        });
    }

    public function createDefaultGroup()
    {
        if (! $this->groups()->exists()) {
            $group = Group::create([
                'name' => Str::title($this->firstname.' '.$this->lastname),
                'description' => 'Default group for '.$this->firstname.' '.$this->lastname,
                'user_id' => $this->id,
                'group_type' => GroupType::CANDIDATE,
            ]);

            $this->groups()->attach($group->id, ['role' => RoleUser::ADMIN]);
        }
    }
}
