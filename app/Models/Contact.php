<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasFactory;

    public function getCodeAttribute()
    {
        return "CO - " . str_pad($this->id, 3, 0, STR_PAD_LEFT);
    }

    public function getSubjectWrapAttribute()
    {
        return Str::limit($this->subject, 30);
    }

    public function getMessageWrapAttribute()
    {
        return Str::limit($this->message, 30);
    }
}
