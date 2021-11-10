<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    public function cities()
    {
        return $this->hasMany(City::class, 'province');
    }
}
