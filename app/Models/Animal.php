<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = ['is_adopted'];

    // This accessor is defined to put a format to our ID and make look professional.
    public function getCodeAttribute()
    {
        return "GCQA - " . str_pad($this->id, 3, 0, STR_PAD_LEFT);
    }

    // This accessor limits the description to a specified characters to wrap them when needed.
    public function getDescriptionWrapAttribute()
    {
        return Str::limit($this->description, 50);
    }

    // This accessor is to capitalize the first letter of the name
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    // This accessor is to capitalize the first letter of the breed
    public function getBreedAttribute($value)
    {
        return ucfirst($value);
    }

    // This accessor is to capitalize the first letter of the type (e.g. Dog, Cat)
    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }

    // This accessor is to capitalize the first letter of the gender (e.g. Male, Female)
    public function getGenderAttribute($value)
    {
        return ucfirst($value);
    }

    // This sets the relationship of the animal to its photos
    public function photos()
    {
        return $this->hasMany(AnimalPhotos::class);
    }

    // This sets the relationship of the animal to its rescuers
    public function rescuers()
    {
        return $this->belongsToMany(Rescuer::class);
    }

    // This sets the relationship of the animal to its adopters
    public function adopters()
    {
        return $this->belongsToMany(Adopter::class);
    }

    // This sets the relationship of the animal to its sickness
    public function sickness()
    {
        return $this->belongsToMany(Sickness::class);
    }
}
