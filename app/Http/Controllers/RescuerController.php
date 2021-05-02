<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Rescuer;
use Illuminate\Http\Request;

class RescuerController extends Controller
{
    // Since store and update method both need validations, 
    //I like to create a separate method so each time I need to validate a request I just call this method.
    private function validateRequest($request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'description' => 'required',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'Maximum length is 255 characters.',
            'last_name.required' => 'Last name is required.',
            'last_name.max' => 'Maximum length is 255 characters.',
            'description.required' => 'Description is required.',
        ]);
    }

    // Same concept with validations, I can just call this method whenver i need to store or update.
    private function saveOrUpdate($rescuer, $request)
    {
        $rescuer->first_name = $request->first_name;
        $rescuer->last_name = $request->last_name;
        $rescuer->description = $request->description;
        $rescuer->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  I like to use $this->data to pass data to view as i find it easier and more convenient than compact(). 
    public function index()
    {
        $this->data['rescuers'] = Rescuer::all();
        return view('pages.rescuers.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with create form.
    public function create()
    {
        return view('pages.rescuers.create_edit');
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
        $rescuer = new Rescuer();
        $this->saveOrUpdate($rescuer, $request);

        return redirect()->route('rescuers.index')->withSuccess('Rescuer successfully added!');
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
        $this->data['rescuer'] = Rescuer::with('animals')->findorFail($id);
        $this->data['animals'] = Animal::all();
        $this->data['animal'] = Animal::with('sickness')->find(1);
        return view('pages.rescuers.show', $this->data);
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
        $this->data['rescuer'] = Rescuer::findorFail($id);
        return view('pages.rescuers.create_edit', $this->data);
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
        $rescuer = Rescuer::findorFail($id);
        $this->saveOrUpdate($rescuer, $request);

        return redirect()->route('rescuers.index')->withSuccess('Rescuer successfully updated!');
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
        Rescuer::destroy($id);

        return redirect()->route('rescuers.index')->withSuccess('Rescuer successfully deleted!');
    }

    // This method is used for adding/removing an animal to the rescuer so that we can list animals they rescued.
    public function attachDetach(Request $request)
    {
        if ($request->item_id == 'default') {
            return redirect()->route('rescuers.show', $request->id)->withErrors('Please select an animal from the menu, then try again.');
        }

        $rescuer = Rescuer::find($request->id);

        if ($request->action == 'attach') {
            if ($rescuer->animals->contains($request->item_id)) {
                return redirect()->route('rescuers.show', $request->id)->withErrors('This animal already exist. Please try again');
            }

            $rescuer->animals()->attach($request->item_id);
            return redirect()->route('rescuers.show', $request->id)->withSuccess('Animal successfully added.');
        } else {
            $rescuer->animals()->detach($request->item_id);
            return redirect()->route('rescuers.show', $request->id)->withSuccess('Animal successfully removed.');
        }
    }
}
