<?php

namespace App\Models;

use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;
    use GenerateUniqueSlugTrait;

    protected $fillable = [
        "name",
        "slug",
        "description",
        "user_id",
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
