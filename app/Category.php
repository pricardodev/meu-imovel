<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'slug', 'created_at', 'updated_at'];

public function realState() {
    
    return $this->belongsToMany(RealState::class, 'real_state_categories');
}

}


