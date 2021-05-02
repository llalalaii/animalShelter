<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalSickness extends Model
{
    use HasFactory;

    // Even though laravel will follow the naming convention, i always like to make sure that the table name for this model is indeed what is specified.
    protected $table = 'animal_sickness';
}
