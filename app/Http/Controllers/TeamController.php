<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Teams\Team;
use App\Models\Teams\Manager;
use App\Models\Whereabouts\Country;
use App\Models\Common\League;

class TeamController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
    
        Team::create([
            'name' => $request->post('name'),
            'country_id' => $request->post('countryId'),
            'manager_id' => $request->post('managerId'),
            'league_id' => $request->post('leagueId'),
            'logo_link' => $request->post('logoLink')
        ]);
        return back()->with('statusCreate', 'Team created successfully.');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Team::find($request->post('id'))->update([
            'name' => $request->post('name'),
            'country_id' => $request->post('countryId'),
            'manager_id' => $request->post('managerId'),
            'league_id' => $request->post('leagueId'),
            'logoLink' => $request->post('logoLink')
        ]);
        return back()->with([
            'statusUpdate' => 'Team updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back()->withErrors($validation);
        
        return view('teamUpdate')->with([
            'team' => Team::find($id),
            'countries' => Country::all(),
            'managers' => Manager::all(),
            'leagues' => League::all()
        ]);
    }

    public function show()
    {
        return view('teamManagement')->with([
            'teams' => DB::table('teams')
                ->join('countries AS c', 'teams.country_id', '=', 'c.id')
                ->join('leagues AS l', 'teams.league_id', '=', 'l.id')
                ->join('managers AS m', 'teams.manager_id', '=', 'm.id')
                ->select('teams.id', 'teams.name', 'teams.logo_link', 'teams.created_at', 
                    'teams.updated_at', 'c.name AS country', 'l.name AS league', 
                    'm.name AS managerName', 'm.surname AS managerSurname')
                ->whereNull('teams.deleted_at')
                ->get(),
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
        if($validation !== true)
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
        if($validation !== true)
            return back()->withErrors($validation);

        Team::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Team restored successfully.');
    }

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'numeric|exists:teams'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:teams',
            'name' => 'required|string|max:255',
            'logoLink' => 'required|string|max:255',
            'countryId' => 'required|numeric|exists:countries,id',
            'managerId' => 'required|numeric|exists:managers,id',
            'leagueId' => 'required|numeric|exists:leagues,id'
        ]);
        if($validation->fails())
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
            'logoLink' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
