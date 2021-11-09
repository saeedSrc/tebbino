<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';

    public function images()
    {
        return $this->hasMany(Image::class, 'center_id');
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'center_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'center_id');
    }
}
