<?php

namespace App\Http\Controllers;

use App\Models\Sickness;
use Illuminate\Http\Request;

class InjuryController extends Controller
{
    // This variable is set to 1 so later on we can identify which is disease or injuries among the list of sickness.

    private $is_injury = 1;
    // Since store and update method both need validations, 
    //I like to create a separate method so each time I need to validate a request I just call this method.
    private function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ], [
            'name.required' => 'Injury name is required.',
            'name.max' => 'Maximum length is 255 characters.',
            'description.required' => 'Description is required.',
         
        ]);
    }

    // Same concept with validations, I can just call this method whenver i need to store or update.
    private function saveOrUpdate($animal, $request)
    {
        $animal->name = $request->name;
        $animal->description = $request->description;
        $animal->is_injury = $this->is_injury;
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
        $this->data['injuries'] = Sickness::where('is_injury', $this->is_injury)->get();
        return view('pages.sickness.injuries.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with create form.
    public function create()
    {
        return view('pages.sickness.injuries.create_edit');
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
        $injury = new Sickness();
        $this->saveOrUpdate($injury, $request);

        return redirect()->route('injuries.index')->withSuccess('Injury successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->data['injury'] = Sickness::findorFail($id);
        return view('pages.sickness.injuries.create_edit', $this->data);
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
        $injury = Sickness::findorFail($id);
        $this->saveOrUpdate($injury, $request);

        return redirect()->route('injuries.index')->withSuccess('Injury successfully updated!');
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
        Sickness::destroy($id);

        return redirect()->route('injuries.index')->withSuccess('Injury successfully deleted!');
    }
}
