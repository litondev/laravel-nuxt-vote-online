<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded = ['id'];
    
    protected $hidden = [
        'password'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function user_votes(){
        return $this->hasMany(UserVote::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = \Hash::make($value); 
    }

    public function getPhotoAttribute($value){
        return asset("/assets/images/users/" . $value);
    }

    public function getPhotoOriginalAttribute($value){
        return $this->attributes["photo"];
    }
}
