<?php

namespace App\Http\Controllers;

use App\Models\Whereabouts\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class CountryController extends Controller
{
    private $picturesFolder = 'images';

    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Country::create([
            'name' => $request->post('name'),
            'picture' => $this->storePicture($request->file('picture'))
        ]);
        return back()->with('statusCreate', 'Country created succesfully');
    }

    public function restore(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:countries'
        ]);
        if($validation->fails())
            return back()->withErrors($validation);
        
        Country::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Country restored succesfully');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);

        $country = Country::find($request->post('id'));
        $country->update([
            'name' => $request->post('name')
        ]);
        if ($request->file('picture') !== null)
            $country->update([
                'picture' => $this->changePicture($country->picture, $request->file('picture'))
            ]);

        return back()->with([
            'statusUpdate' => 'Country updated succesfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)    
            return back()->withErrors($validation);

        Country::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Country deleted succesfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function show()
    {
        return view('countryManagement')->with('countries', Country::all());
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();

        return view('countryUpdate')->with('country', Country::find($id));
    }

    private function changePicture($oldPicture, $newPicture)
    {
        File::delete($this->picturesFolder . '/' . $oldPicture);
        return $this->storePicture($newPicture);
    }

    private function storePicture($file)
    {
        $fileName = Str::random(32) . '.' . $file->extension();
        $file->move($this->picturesFolder, $fileName);
        return $fileName;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'picture' => 'required|image|max:5000'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:countries',
            'name' => 'required|string|max:255',
            'picture' => 'nullable|image|max:5000'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'numeric|exists:countries'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

}
