<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Players\Player;
use App\Models\Whereabouts\Country;

class PlayerController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Player::create([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'height' => $request->post('height'),
            'weight' => $request->post('weight'),
            'country_id' => $request->post('countryId')
        ]);
        return back()->with('statusCreate', 'Player created succesfully.');
    }
    
    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Player::find($request->post('id'))->update([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'height' => $request->post('height'),
            'weight' => $request->post('weight'),
            'country_id' => $request->post('countryId')
        ]);
        return back()->with([
            'statusUpdate' => 'Player updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();
        return view('playerUpdate')->with([
            'player' => Player::find($id),
            'countries' => Country::all()
        ]);
    }

    public function show()
    {
        return view('playerManagement')->with([
            'players' => DB::table('players')
                    ->join('countries', 'players.country_id', '=', 'countries.id')
                    ->whereNull('players.deleted_at')
                    ->select(
                        'players.id', 'players.name', 'players.surname', 
                        'players.birth_date', 'players.height', 'players.weight', 
                        'countries.name as country', 'players.created_at', 'players.updated_at'
                    )
                    ->get(),
            'countries' => Country::all()
        ]);
    }

    /**
     * Chequear esto cuando hagamos la relacion entre jugadores y 
     * equipos, porque si elimino un jugador, lo doy de baja del equipo.
     */
    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)    
            return back()->withErrors($validation);

        Player::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Player deleted successfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Player::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Player restored successfully.');
    }

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'numeric|exists:players'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:players',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthDate' => 'required|string|before:today',
            'height' => 'required|digits_between:2,3',
            'weight' => 'required|digits_between:2,3',
            'countryId' => 'required|numeric|exists:countries,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthDate' => 'required|string|before:today',
            'height' => 'required|digits_between:2,3',
            'weight' => 'required|digits_between:2,3',
            'countryId' => 'required|numeric|exists:countries,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
