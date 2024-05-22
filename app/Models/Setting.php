<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        '2fa',
        'private_account',
        'recipe_recommendation',
        'user_id',
        'friends_activities',
        'promotional_updates',
        'system_notification',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
