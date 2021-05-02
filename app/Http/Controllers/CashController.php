<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class CashController extends Controller
{
    private $is_cash = 1;
    // Since store and update method both need validations, 
    //I like to create a separate method so each time I need to validate a request I just call this method.
    private function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'value' => 'required|integer',
        ]);
    }

    // Same concept with validations, I can just call this method whenver i need to store or update.
    private function saveOrUpdate($cash, $request)
    {
        $cash->name = $request->name;
        $cash->value = $request->value;
        $cash->is_cash = $this->is_cash;
        $cash->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  I like to use $this->data to pass data to view as i find it easier and more convenient than compact(). 
    public function index()
    {
        $this->data['cash'] = Donation::where('is_cash', $this->is_cash)->get();
        return view('pages.donations.cash.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with create form.
    public function create()
    {
        return view('pages.donations.cash.create_edit');
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
        $cash = new Donation();
        $this->saveOrUpdate($cash, $request);

        return redirect()->route('cash.index')->withSuccess('Cash donation successfully added!');
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
        $this->data['cash'] = Donation::findorFail($id);
        return view('pages.donations.cash.create_edit', $this->data);
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
        $cash = Donation::findorFail($id);
        $this->saveOrUpdate($cash, $request);

        return redirect()->route('cash.index')->withSuccess('Cash donation successfully updated!');
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

        return redirect()->route('cash.index')->withSuccess('Cash donation successfully deleted!');
    }
}