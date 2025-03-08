<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\CreateDefaultGroupTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $email_verified_at
 * @property \Illuminate\Database\Eloquent\Collection<Group> $ownedGroups
 * @property \Illuminate\Database\Eloquent\Collection<Group> $groups
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
}
