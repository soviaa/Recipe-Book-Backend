<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use Searchable, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'prep_time',
        'cook_time',
        'servings',
        'difficulty',
        'recipe_type',
        'image',
        'user_id',
        'category_id',
        'is_private',
        'is_approved'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

