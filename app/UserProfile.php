<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['about', 'phone', 'mobile_phone', 'social_networks','created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
