<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Stmt\ElseIf_;

class MainController extends Controller
{
    // I list all the animals which don't have any disease/injuries (sickness) to show unauthorized guest which animals are ready for adoption.
    // additionally I will not showing animals that are already adopted
    public function home()
    {
        return view('pages.home.index');
    }

    public function adoptable()
    {
        $animals = Animal::doesntHave('sickness')->where('is_adopted', 0)->get();

        return response()->json(compact('animals'));
    }

    public function adoptableSearch($name)
    {
        $animals = Animal::with('photos')->where('name', 'LIKE', '%' . $name . '%')->get();
        return Response::json(compact('animals'));
    }
}
