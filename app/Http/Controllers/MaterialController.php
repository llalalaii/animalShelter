<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    // This variable is set to 0 so later on we can identify which is cash or material among the list of donations.
    private $is_cash = 0;
    // Since store and update method both need validations, 
    //I like to create a separate method so each time I need to validate a request I just call this method.
    private function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'value' => 'required|integer',
            'unit' => 'required|max:255',
        ]);
    }

    // Same concept with validations, I can just call this method whenver i need to store or update.
    private function saveOrUpdate($material, $request)
    {
        $material->name = $request->name;
        $material->value = $request->value;
        $material->unit = $request->unit;
        $material->is_cash = $this->is_cash;
        $material->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  I like to use $this->data to pass data to view as i find it easier and more convenient than compact(). 
    public function index()
    {
        $this->data['materials'] = Donation::where('is_cash', $this->is_cash)->get();
        return view('pages.donations.materials.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with create form.
    public function create()
    {
        return view('pages.donations.materials.create_edit');
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
        $material = new Donation();
        $this->saveOrUpdate($material, $request);

        return redirect()->route('materials.index')->withSuccess('Material donation successfully added!');
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
        $this->data['material'] = Donation::findorFail($id);
        return view('pages.donations.materials.create_edit', $this->data);
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
        $material = Donation::findorFail($id);
        $this->saveOrUpdate($material, $request);

        return redirect()->route('materials.index')->withSuccess('Material donation successfully updated!');
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
        Donation::destroy($id);

        return redirect()->route('materials.index')->withSuccess('Material donation successfully deleted!');
    }
}
