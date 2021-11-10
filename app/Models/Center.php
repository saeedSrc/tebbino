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

    public function hoursOfWorks()
    {
        return $this->belongsTo(HoursOfWork::class, 'hours_of_work_id');
    }

    public function specialTests()
    {
        return $this->belongsToMany(SpecialTest::class, 'center_special_test')->withPivot('id');
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'center_doctor')->withPivot('id');
    }


}
