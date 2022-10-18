<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Models\Whereabouts\Venue;

class VenueController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Venue::create([
            'name' => $request->post('name')
        ]);
        return back()->with('statusCreate', 'Venue created succesfully');
    }

    public function restore(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:countries'
        ]);
        if($validation->fails())
            return back()->withErrors($validation);
        
        Venue::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Venue restored succesfully');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Venue::find($request->post('id'))->update([
            'name' => $request->post('name')
        ]);
        return back()->with([
            'statusUpdate' => 'Venue updated succesfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)    
            return back()->withErrors($validation);

        Venue::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Venue deleted succesfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function show()
    {
        return view('venueManagement')->with('venues', Venue::all());
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();

        return view('venueUpdate')->with('venue', Venue::find($id));
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:countries',
            'name' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'numeric|exists:venues'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
