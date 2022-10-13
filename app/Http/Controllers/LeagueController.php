<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Common\League;
use App\Models\Common\Sport;
use App\Models\Whereabouts\Country;

class LeagueController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        League::create([
            'name' => $request->post('name'),
            'logo_link' => $request->post('logoLink'),
            'country_id' => $request->post('countryId'),
            'sport_id' => $request->post('sportId')
        ]);
        return back()->with('statusCreate', 'League created successfully.');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);

        League::find($request->post('id'))->update([
            'name' => $request->post('name'),
            'logo_link' => $request->post('logoLink'),
            'country_id' => $request->post('countryId'),
            'sport_id' => $request->post('sportId')
        ]);
        return back()->with([
            'statusUpdate' => 'League updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();

        return view('leagueUpdate')->with([
            'league' => League::find($id),
            'countries' => Country::all(),
            'sports' => Sport::all()
        ]);
    }

    public function show()
    {
        return view('leagueManagement')->with([
            'leagues' => DB::table('leagues')
                        ->join('sports', 'leagues.sport_id', '=', 'sports.id')
                        ->join('countries', 'leagues.country_id', '=', 'countries.id')
                        ->select('leagues.id', 'leagues.created_at', 'leagues.updated_at',
                            'leagues.name', 'leagues.logo_link', 'countries.name as country', 'sports.name as sport')
                        ->whereNull('leagues.deleted_at')
                        ->get(),
            'sports' => Sport::all(),
            'countries' => Country::all()
        ]);
    }

    /**
     * Revisar esto cuando se implemente la gestiond de eventos,
     * equipos, resultados y sanciones, ya que deberán ser borrados
     * cuando se borre una liga.
     */
    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        League::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'League deleted successfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        League::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'League restored successfully');
    }

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'numeric|exists:leagues'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:leagues',
            'name' => 'required|string|max:255',
            'logoLink' => 'required|string|max:255',
            'countryId' => 'required|numeric|exists:countries,id',
            'sportId' => 'required|numeric|exists:sports,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'logoLink' => 'required|string|max:255',
            'countryId' => 'required|numeric|exists:countries,id',
            'sportId' => 'required|numeric|exists:sports,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
