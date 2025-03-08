<?php

namespace App\Models;

use App\Enums\GroupType;
use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property GroupType $group_type
 * @property int $user_id
 * @property User $user
 */
class Group extends Model
{
    use GenerateUniqueSlugTrait;

    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'group_type',
        'description',
        'user_id',
    ];

    public $casts = [
        'group_type' => GroupType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
