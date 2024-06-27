<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'savedRecipe',
        'sharedRecipe',
    ];

    protected $casts = [
        'savedRecipe' => 'array',
        'sharedRecipe' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
