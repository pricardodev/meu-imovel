<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealStatePhoto extends Model
{
    protected $fillable = ['photo', 'is_thumb', 'created_at', 'updated_at'];

    public function realState()
    {
        return $this->belongsTo(RealState::class);
    }
}
