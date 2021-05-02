<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalPhotos;
use App\Models\Sickness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AnimalController extends Controller
{
    // Since store and update method both need validations, 
    //I like to create a separate method so each time I need to validate a request I just call this method.
    private function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'breed' => 'required|max:255',
            'gender' => 'required|max:255',
            'age' => 'required|integer',
            'type' => 'required|max:255',
        ], [
            'name.required' => 'First name is required.',
            'name.max' => 'Maximum length is 255 characters.',
            'breed.required' => 'Breed is required.',
            'breed.max' => 'Maximum length is 255 characters.',
            'gender.required' => 'Animal Gender is required.',
            'gender.max' => 'Maximum length is 255 characters.',
            'age.required' => 'Age is required',
            'age.integer' => 'Age should be an integer.',
            'type.required' => 'Animal Type is required.',
            'type.max' => 'Maximum length is 255 characters.',
        ]);
    }

    // Same concept with validations, I can just call this method whenver i need to store or update.
    private function saveOrUpdate($animal, $request)
    {
        $animal->name = $request->name;
        $animal->breed = $request->breed;
        $animal->gender = $request->gender;
        $animal->age = $request->age;
        $animal->type = $request->type;
        $animal->description = $request->description;
        $animal->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  I like to use $this->data to pass data to view as i find it easier and more convenient than compact(). 
    public function index()
    {
        $this->data['animals'] = Animal::all();
        return view('pages.animals.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with create form.
    public function create()
    {
        return view('pages.animals.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  This method is used for storing data that uses the validateRequest and saveOrUpdate methods.
    public function store(Request $request)
    {
        $this->validateRequest($request);
        $animal = new Animal();
        $this->saveOrUpdate($animal, $request);

        return redirect()->route('animals.index')->withSuccess('Animal successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // This method used an ID to show a page with specifics. 
    public function show($id)
    {
        $this->data['animal'] = Animal::with('photos')->with('sickness')->findorFail($id);
        $this->data['sicknesses'] = Sickness::all();

        return view('pages.animals.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with edit form. 
    // However instead of using a different blade template I prefer using the same one as the create page, to make it easier to refactor.
    public function edit($id)
    {
        $this->data['animal'] = Animal::findorFail($id);
        return view('pages.animals.create_edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // This method is used for updating that is like store method which uses the validateRequest and saveOrUpdate methods.
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $animal = Animal::findorFail($id);
        $this->saveOrUpdate($animal, $request);

        return redirect()->route('animals.index')->withSuccess('Animal successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  This method deletes using a specific id
    public function destroy($id)
    {
        Animal::destroy($id);

        return redirect()->route('animals.index')->withSuccess('Animal successfully deleted!');
    }

    // This method is for uploading a photo/s of a specific animal.
    public function uploadPhotos(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        DB::transaction(function () use ($request) {
            if ($request->hasfile('images')) {
                foreach ($request->file('images') as $image) {
                    $name =  $request->id . "-" . time() . '.' . $image->extension();
                    $animalPhoto = new AnimalPhotos();
                    $animalPhoto->animal_id = $request->id;
                    $animalPhoto->image = $name;
                    $animalPhoto->save();
                    $image->move(storage_path() . '/app/public/images/', $name);
                }
            }
        });
        return redirect()->back()->withSuccess('Photos successfully added!');
    }

    // This method is for removing of photos.
    public function removePhotos($id)
    {
        AnimalPhotos::destroy($id);

        return redirect()->back()->withSuccess('Photos successfully deleted!');
    }

    // This method is used for adding/removing an sickness to the animal so that we can list diseases/injuries for each of them.
    public function attachDetachSickness(Request $request)
    {
        if ($request->item_id == 'default') {
            return redirect()->route('animals.show', $request->id)->withErrors('Please select an animal from the menu, then try again.');
        }

        $animal = Animal::find($request->id);

        if ($request->action == 'attach') {
            if ($animal->sickness->contains($request->item_id)) {
                return redirect()->route('animals.show', $request->id)->withErrors('This disease/injury already exist. Please try again');
            }

            $animal->sickness()->attach($request->item_id);
            return redirect()->route('animals.show', $request->id)->withSuccess('Sickness successfully added.');
        } else {
            $animal->sickness()->detach($request->item_id);
            return redirect()->route('animals.show', $request->id)->withSuccess('Sickness successfully removed.');
        }
    }
}
