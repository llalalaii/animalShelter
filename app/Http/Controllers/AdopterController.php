<?php

namespace App\Http\Controllers;

use App\Models\Adopter;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdopterController extends Controller
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
    private function saveOrUpdate($adopter, $request)
    {
        $adopter->first_name = $request->first_name;
        $adopter->last_name = $request->last_name;
        $adopter->description = $request->description;
        $adopter->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  I like to use $this->data to pass data to view as i find it easier and more convenient than compact().
    public function index()
    {
        $this->data['adopters'] = Adopter::all();
        return view('pages.adopters.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with create form.
    public function create()
    {
        return view('pages.adopters.create_edit');
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
        $adopter = new Adopter();
        $this->saveOrUpdate($adopter, $request);

        return redirect()->route('adopters.index')->withSuccess('Adopter successfully added!');
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
        $this->data['adopter'] = Adopter::with('animals')->findorFail($id);
        // We are only going to fetch animals which are not adopted.
        $this->data['animals'] = Animal::doesntHave('sickness')->where('is_adopted', 0)->get();
        return view('pages.adopters.show', $this->data);
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
        $this->data['adopter'] = Adopter::findorFail($id);
        return view('pages.adopters.create_edit', $this->data);
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
        $adopter = Adopter::findorFail($id);
        $this->saveOrUpdate($adopter, $request);

        return redirect()->route('adopters.index')->withSuccess('Adopter successfully updated!');
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
        Adopter::destroy($id);

        return redirect()->route('adopters.index')->withSuccess('Adopter successfully deleted!');
    }

    // This method is used for adding/removing an animal to the adopter so that we can list animals they adopted.
    public function attachDetach(Request $request)
    {
        if ($request->item_id == 'default') {
            return redirect()->route('adopters.show', $request->id)->withErrors('Please select an animal from the menu, then try again.');
        }

        $adopter = Adopter::find($request->id);

        if ($request->action == 'attach') {
            if ($adopter->animals->contains($request->item_id)) {
                return redirect()->route('adopters.show', $request->id)->withErrors('This animal already exist. Please try again');
            }

            Animal::findorFail($request->item_id)->update([
                'is_adopted' => 1,
            ]);

            $adopter->animals()->attach($request->item_id);
            return redirect()->route('adopters.show', $request->id)->withSuccess('Animal successfully added.');
        } else {

            Animal::findorFail($request->item_id)->update([
                'is_adopted' => 0,
            ]);
            $adopter->animals()->detach($request->item_id);
            return redirect()->route('adopters.show', $request->id)->withSuccess('Animal successfully removed.');
        }
    }
}
