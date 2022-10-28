<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Teams\Manager;
use App\Models\Whereabouts\Country;

class ManagerController extends Controller
{
    private $profilePicturesFolder = 'images';

    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if ($validation !== true)
            return back()->withErrors($validation);

        Manager::create([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'country_id' => $request->post('countryId'),
            'picture' => $this->storeProfilePicture($request->file('picture'))
        ]);
        return back()->with('statusCreate', 'Manager created succesfully');
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if ($validation !== true)
            return back()->withErrors($validation);
        
        Manager::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Manager restored succesfully');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if ($validation !== true)
            return back()->withErrors($validation);

        $manager = Manager::find($request->post('id'));
        $manager->update([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'country_id' => $request->post('countryId')
        ]);
        if ($request->file('picture') !== null)
            $manager->update([
                'picture' => $this->changeProfilePicture($manager->picture, $request->file('picture'))
            ]);
        
        return back()->with([
            'statusUpdate' => 'Manager updated succesfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if ($validation !== true)
            return back()->withErrors($validation);

        Manager::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Manager deleted succesfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function show()
    {
        return view('managerManagement', [
            'managers' => Manager::all(),
            'countries' => Country::all()
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if ($validation !== true)
            return back();
        
        return view('managerUpdate', [
            'manager' => Manager::find($id),
            'countries' => Country::all()
        ]);
    }

    private function changeProfilePicture($oldPicture, $newPicture)
    {
        File::delete($this->profilePicturesFolder . '/' . $oldPicture);
        return $this->storeProfilePicture($newPicture);
    }

    private function storeProfilePicture($file)
    {
        $fileName = Str::random(32) . '.' . $file->extension();
        $file->move($this->profilePicturesFolder, $fileName);
        return $fileName;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthDate' => 'required|date|before:today',
            'countryId' => 'required|exists:countries,id',
            'picture' => 'required|image|max:5000'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
        
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:managers',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthDate' => 'required|date',
            'countryId' => 'required|numeric|exists:countries,id',
            'picture' => 'nullable|image|max:5000'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:managers'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }
}
