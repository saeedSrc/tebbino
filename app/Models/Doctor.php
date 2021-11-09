<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
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
}
