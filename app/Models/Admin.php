<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    public function hasRole($role)
{
    // Assuming role is a column in your admins table
    return $this->role === $role;
}
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}
