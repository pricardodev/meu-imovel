<?php

namespace App;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function real_state()
    {
        return $this->hasMany(RealState::class);
    }

    //Busca dentro da tabela user um campo profile_id
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function getJWTIdentifier()
    {
         return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // adicionando clims no token
        return [];
    }
}
