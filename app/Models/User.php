<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Model\ScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Schema;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ScopeTrait;

    protected $fillable = [
        'id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function profile() :HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function scopeRole($query, $roles)
    {
        if(empty($roles))
            return $query;
        return $query->whereIn('role', $roles);
    }

    public function scopeStatus($query, $statuses)
    {
        if(empty($statuses))
            return $query;
        return $query->whereIn('status', $statuses);
    }
}
