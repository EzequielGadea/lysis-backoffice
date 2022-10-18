<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Models\Whereabouts\City;
use App\Models\Whereabouts\Country;

class CityController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);

        City::create([
            'name' => $request->post('name'),
            'country_id' => $request->post('countryId')
        ]);
        return back()->with('statusCreate', 'City created succesfully');
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);

        City::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'City restored succesfully');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);

        City::find($request->post('id'))->update([
            'name' => $request->post('name'),
            'country_id' => $request->post('countryId')
        ]);
        return back()->with([
            'statusUpdate' => 'City updated succesfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
       
       City::destroy($request->post('id')); 
       return back()->with([
        'statusDelete' => 'City deleted succesfully.',
        'deletedId' => $request->post('id')
        ]);
    }

    public function show()
    {
        return view('cityManagement')->with([
            'cities' => City::all(),
            'countries' => Country::all()
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();
        
        return view('cityUpdate')->with([
            'city' => City::find($id),
            'countries' => Country::all()
        ]);
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'countryId' => 'required|exists:countries,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:cities',
            'name' => 'required|string|max:255',
            'countryId' => 'required|numeric|exists:countries,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:cities'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

}
