<?php

namespace App\Http\Controllers;

use App\Models\Sickness;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    // This variable is set to 0 so later on we can identify which is disease or injuries among the list of sickness.
    private $is_injury = 0;
    // Since store and update method both need validations, 
    //I like to create a separate method so each time I need to validate a request I just call this method.
    private function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
    }

    // Same concept with validations, I can just call this method whenver i need to store or update.
    private function saveOrUpdate($disease, $request)
    {
        $disease->name = $request->name;
        $disease->description = $request->description;
        $disease->is_injury = $this->is_injury;
        $disease->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  I like to use $this->data to pass data to view as i find it easier and more convenient than compact(). 
    public function index()
    {
        $this->data['diseases'] = Sickness::where('is_injury', $this->is_injury)->get();
        return view('pages.sickness.diseases.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with create form.
    public function create()
    {
        return view('pages.sickness.diseases.create_edit');
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
        $disease = new Sickness();
        $this->saveOrUpdate($disease, $request);

        return redirect()->route('diseases.index')->withSuccess('Disease successfully added!');
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
        $this->data['disease'] = Sickness::findorFail($id);
        return view('pages.sickness.diseases.create_edit', $this->data);
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
        $disease = Sickness::findorFail($id);
        $this->saveOrUpdate($disease, $request);

        return redirect()->route('diseases.index')->withSuccess('Disease successfully updated!');
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

        return redirect()->route('diseases.index')->withSuccess('Disease successfully deleted!');
    }
}
