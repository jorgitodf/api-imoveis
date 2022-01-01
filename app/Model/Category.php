<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name','description','slug'];

    public function realStates()
    {
        return $this->belongsToMany(RealState::class, 'real_state_has_categories');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(mb_convert_case($value, MB_CASE_TITLE, "UTF-8"));
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = trim(mb_convert_case($value, MB_CASE_TITLE, "UTF-8"));
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = trim(strtolower($value));
    }
}
