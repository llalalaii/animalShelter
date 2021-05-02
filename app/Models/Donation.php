<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    // This accessor is defined to put a format to our ID and make look professional.
    // Additionally i have to put a ternary operator to identify which code i am going to put whether "GCQC" = cash or "GCQM" = material donations.
    public function getCodeAttribute()
    {
        $code = $this->is_cash == 1 ?  "GCQC - " : "GCQM - ";
        return $code . str_pad($this->id, 3, 0, STR_PAD_LEFT);
    }

    // This accessor is used to set the first letter of the name to capital letter. 
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
