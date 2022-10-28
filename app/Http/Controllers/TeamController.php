<?php

namespace App\Http\Controllers;

use App\Models\Common\League;
use App\Models\Teams\Team;
use App\Models\Teams\Manager;
use App\Models\Whereabouts\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    private $picturesFolder = 'images';

    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if ($validation !== true)
            return back()->withErrors($validation);
    
        Team::create([
            'name' => $request->post('name'),
            'country_id' => $request->post('countryId'),
            'manager_id' => $request->post('managerId'),
            'league_id' => $request->post('leagueId'),
            'picture' => $this->storePicture($request->file('picture'))
        ]);
        return back()->with('statusCreate', 'Team created successfully.');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if ($validation !== true)
            return back()->withErrors($validation);
        
        $team = Team::find($request->post('id'));
        $team->update([
            'name' => $request->post('name'),
            'country_id' => $request->post('countryId'),
            'manager_id' => $request->post('managerId'),
            'league_id' => $request->post('leagueId'),
        ]);
        if ($request->file('picture') !== null)
            $team->update([
                'picture' => $this->changePicture($team->picture, $request->file('picture'))
            ]);
        return back()->with([
            'statusUpdate' => 'Team updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if ($validation !== true)
            return back()->withErrors($validation);
        
        return view('teamUpdate', [
            'team' => Team::find($id),
            'countries' => Country::all(),
            'managers' => Manager::all(),
            'leagues' => League::all()
        ]);
    }
    
    public function show()
    {
        return view('teamManagement', [
            'teams' => Team::all(),
            'countries' => Country::all(),
            'managers' => Manager::all(),
            'leagues' => League::all()
        ]);
    }

    /**
     * Todo: cuando se elimina un equipo se eliminan las relaciones
     * que tiene con otras entidades.
     */
    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if ($validation !== true)
            return back()->withErrors($validation);
    
        Team::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Team deleted successfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if ($validation !== true)
            return back()->withErrors($validation);

        Team::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Team restored successfully.');
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

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'numeric|exists:teams'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:teams',
            'name' => 'required|string|max:255',
            'countryId' => 'required|numeric|exists:countries,id',
            'managerId' => 'required|numeric|exists:managers,id',
            'leagueId' => 'required|numeric|exists:leagues,id',
            'picture' => 'nullable|image|max:5000'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'countryId' => 'required|numeric|exists:countries,id',
            'managerId' => 'required|numeric|exists:managers,id',
            'leagueId' => 'required|numeric|exists:leagues,id',
            'picture' => 'required|image|max:5000'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }
}
