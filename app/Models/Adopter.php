<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Adopter extends Model
{
    use HasFactory;

    // This accessor is defined to put a format to our ID and make look professional.
    public function getCodeAttribute()
    {
        return "GCQAD - " . str_pad($this->id, 3, 0, STR_PAD_LEFT);
    }

    // This accessor is defined so that we can access full_name of adopters when needed.
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . " " . ucfirst($this->last_name);
    }

    // This accessor is to capitalize the first letter of the first name
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    // This accessor is to capitalize the first letter of the last name
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    // This accessor limits the description to a specified characters to wrap them when needed.
    public function getDescriptionWrapAttribute()
    {
        return Str::limit($this->description, 50);
    }

    // This sets the relationship of the adopter to animals
    public function animals()
    {
        return $this->belongsToMany(Animal::class);
    }
}
