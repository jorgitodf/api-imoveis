<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile';
    protected $fillable = ['phone','mobile_phone','about','social_networks'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = implode(array_filter(str_split($value), 'is_numeric'));
    }

    public function setMobilePhoneAttribute($value)
    {
        $this->attributes['mobile_phone'] = implode(array_filter(str_split($value), 'is_numeric'));
    }
}
