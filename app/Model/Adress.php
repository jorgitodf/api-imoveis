<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function real_state()
    {
        return $this->hasOne(RealState::class);
    }
}
