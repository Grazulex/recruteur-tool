<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GroupType;
use App\Enums\RoleUser;
use App\Traits\CreateDefaultGroupTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $ownedGroups
 * @property-read int|null $owned_groups_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use CreateDefaultGroupTrait, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's full name
     */
    public function fullname(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->fullname())
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function ownedGroups(): HasMany
    {
        return $this->hasMany(
            related: Group::class,
            foreignKey: 'user_id'
        );
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Group::class,
            table: 'group_user'
        )
            ->withPivot(
                columns: 'role'
            )
            ->withTimestamps();
    }

    public function usersInMyAdminGroups()
    {
        return User::join('group_user as gu1', 'users.id', '=', 'gu1.user_id')
            ->join('groups', 'gu1.group_id', '=', 'groups.id')
            ->join('group_user as gu2', 'gu1.group_id', '=', 'gu2.group_id')
            ->where('gu2.user_id', Auth::user()->id)
            ->where('gu2.role', RoleUser::ADMIN)
            ->where('users.id', '!=', Auth::user()->id)
            ->select('users.*', 'groups.id as group_id', 'groups.name as group_name', 'groups.group_type as group_type', 'gu1.role as user_role')
            ->distinct()
            ->get()
            ->map(function ($user) {
                $user->user_role = RoleUser::tryFrom($user->user_role); // Convertir en Enum

                return $user;
            })
            ->map(function ($user) {
                $user->group_type = GroupType::tryFrom($user->group_type); // Convertir en Enum

                return $user;
            });
    }
}
