<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sickness extends Model
{
    use HasFactory;

    // This accessor is defined to put a format to our ID and make look professional.
    public function getCodeAttribute()
    {
        return "GCQS - " . str_pad($this->id, 3, 0, STR_PAD_LEFT);
    }

    // This accessor is to capitalize the first letter of the name
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    // This accessor limits the description to a specified characters to wrap them when needed.
    public function getDescriptionWrapAttribute()
    {
        return Str::limit($this->description, 50);
    }

    // This sets the relationship of the animals to its sickness (whether disease or injury)
    public function animals()
    {
        return $this->belongsToMany(Animal::class);
    }
}
