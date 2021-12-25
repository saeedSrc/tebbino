<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';

    protected $appends = array('image_base_path');

    public function getImageBasePathAttribute()
    {
        return config('constants.doctor_images_base_path');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'doctor_id');
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'doctor_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'doctor_id');
    }


    public function specialties()
    {
        return $this->belongsToMany(Specialty::class);
    }

    public function centers()
    {
        return $this->belongsToMany(Center::class, 'center_doctor')->withPivot('id');
    }

}
