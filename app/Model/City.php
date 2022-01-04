<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function adresses()
    {
        return $this->hasMany(Adress::class);
    }
}
