<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AnimalRescuer extends Pivot
{
    use HasFactory;

    // Even though laravel will follow the naming convention, i always like to make sure that the table name for this model is indeed what is specified.
    protected $table = 'animal_rescuer';
}
