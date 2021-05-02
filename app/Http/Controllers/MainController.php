<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class MainController extends Controller
{
    // We list all the animals which don't have any disease/injuries (sickness) to show unauthorized guest which animals are ready for adoption. 
    // additionally we are not showing animals that are already adopted
    public function home()
    {
        $animals = Animal::doesntHave('sickness')->where('is_adopted', 0)->get();

        return view('pages.home.index', compact('animals'));
    }
}
