<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    protected $fillable = ['name', 'license_number', 'phone'];
}
