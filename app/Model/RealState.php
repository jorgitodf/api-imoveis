<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Helpers\Helpers;

class RealState extends Model
{
    protected $table = 'real_state';
    protected $fillable = ['user_id','title' ,'description','content','price', 'bathrooms','bedrooms','property_area',
    'total_property_area','slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'real_state_has_categories');
    }

    public function photos()
    {
        return $this->hasMany(RealStatePhoto::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim(mb_convert_case($value, MB_CASE_TITLE, "UTF-8"));
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = trim(mb_convert_case($value, MB_CASE_TITLE, "UTF-8"));
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = trim(mb_convert_case($value, MB_CASE_TITLE, "UTF-8"));
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = Helpers::formatarMoeda($value);
    }

    public function setBathroomsAttribute($value)
    {
        $this->attributes['bathrooms'] = trim($value);
    }

    public function setBedroomsAttribute($value)
    {
        $this->attributes['bedrooms'] = trim($value);
    }

    public function setPropertyAreaAttribute($value)
    {
        $this->attributes['property_area'] = trim($value);
    }

    public function setTotalPropertyAreaAttribute($value)
    {
        $this->attributes['total_property_area'] = trim($value);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = trim(strtolower($value));
    }

    public function getPriceAttribute($value)
    {
        return Helpers::formatarMoedaEnPt($value);
    }
}
