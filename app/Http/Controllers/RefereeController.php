<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Models\Events\Referee;
use App\Models\Whereabouts\Country;

class RefereeController extends Controller
{
    private $profilePicturesFolder = 'images';

    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Referee::create([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'country_id' => $request->post('countryId'),
            'picture' => $this->storeProfilePicture($request->file('picture'))
        ]);
        return back()->with('statusCreate', 'Referee created succesfuly');
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Referee::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Referee restored succesfuly');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);

        $referee = Referee::find($request->post('id'));
        $referee->update([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'country_id' => $request->post('countryId')
        ]);
        if($request->file('picture') !== null)
            $referee->update([
                'picture' => $this->storeProfilePicture($request->file('picture'))
            ]);

        return back()->with([
            'statusUpdate' => 'Referee updated succesfuly, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Referee::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Referee deleted succesfuly.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function show()
    {
        return view('refereeManagement')->with([
            'referees' => Referee::all(),
            'countries' => Country::all()
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();
        
        return view('refereeUpdate')->with([
            'referee' => Referee::find($id),
            'countries' => Country::all()
        ]);
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
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'birthDate' => 'required|date|before:today',
            'countryId' => 'required|exists:countries,id',
            'picture' => 'required|image|max:5000'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:referees',
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'birthDate' => 'required|date',
            'countryId' => 'required|numeric|exists:countries,id',
            'picture' => 'nullable|image|max:5000'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:referees'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
