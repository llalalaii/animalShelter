<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // Since store and update method both need validations,
    //I like to create a separate method so each time I need to validate a request I just call this method.
    private function validateRequest($request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'position' => 'required|max:255',
            'password' => 'required|min:6|max:255|confirmed',
        ]);
    }

    // Same concept with validations, I can just call this method whenver i need to store or update.
    private function saveOrUpdate($employee, $request)
    {
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->password = Hash::make($request->password);
        $employee->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  I like to use $this->data to pass data to view as i find it easier and more convenient than compact().
    public function index()
    {
        $this->data['employees'] = User::all();
        return view('pages.employees.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  This method shows the page with create form.
    public function create()
    {
        return view('pages.employees.create_edit');
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
        $employee = new User();
        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users',
            ],
        ]);
        $this->saveOrUpdate($employee, $request);

        return redirect()->route('employees.index')->withSuccess('Employee successfully added!');
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
        $this->data['employee'] = User::findorFail($id);
        return view('pages.employees.create_edit', $this->data);
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
        $employee = User::findorFail($id);
        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($employee),
            ],
        ]);
        $this->saveOrUpdate($employee, $request);

        return redirect()->route('employees.index')->withSuccess('Employee successfully updated!');
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
        User::destroy($id);

        return redirect()->route('employees.index')->withSuccess('Employee successfully deleted!');
    }
}
