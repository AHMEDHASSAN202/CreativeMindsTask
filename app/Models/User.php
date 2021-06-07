<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = ['mobile_verified_at' => 'datetime'];

    //============== Relations ====================\\

    public function verifyCode()
    {
        return $this->hasOne(VerifyCode::class)->latest();
    }

    //============== #END# Relations ================\\

    public function isVerifiedMobile() : bool
    {
        return $this->mobile_verified_at !== null;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //=========== Scopes =============================\\
    public function scopeUser($query)
    {
        return $query->where('role', 'user');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeSearch($query, $request)
    {
        if ($s = $request->query('s')) {
            return $query->where('username', 'LIKE', '%' . $s . '%')->orWhere('mobile', 'LIKE', '%' . $s . '%');
        }
    }
    //=========== #END# Scopes =============================\\
}
