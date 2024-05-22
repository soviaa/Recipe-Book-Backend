<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        '2fa',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
