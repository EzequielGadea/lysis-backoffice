<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Teams\Team;
use App\Models\Players\Player;
use App\Models\Players\Position;
use App\Models\Players\PlayerTeam;

class PlayerTeamController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        PlayerTeam::create([
            'player_id' => $request->post('playerId'),
            'team_id' => $request->post('teamId'),
            'contract_start' => $request->post('contractStart'),
            'shirt_number' => $request->post('shirtNumber'),
            'position_id' => $request->post('positionId')
        ]);

        return back()->with('statusRegister', 'Player added successfully.');
    }
    
    public function show($teamId)
    {
        $validation = $this->validateTeamId(collect(['teamId' => $teamId]));
        if($validation !== true)
            return back();

        return view('teamPlayersManagement')->with([
            'team' => Team::find($teamId),
            'players' => Player::all(),
            'positions' => Position::all()
        ]);
    }

    public function edit($playerTeamId)
    {
        $validation = $this->validatePlayerTeamId(collect(['playerTeamId' => $playerTeamId]));
        if($validation !== true)
            return back();
    
        return view('teamPlayerUpdate')->with([
            'playerTeam' => PlayerTeam::find($playerTeamId),
            'positions' => Position::all()
        ]);
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        PlayerTeam::find($request->post('playerTeamId'))->update([
            'position_id' => $request->post('positionId'),
            'shirt_number' => $request->post('shirtNumber'),
            'contract_start' => $request->post('contractStart')
        ]);
        return back()->with([
            'statusUpdate' => 'Player updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = $this->validatePlayerTeamId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        PlayerTeam::destroy($request->post('playerTeamId'));
        return back()->with([
            'statusDelete' => 'Player removed successfully.',
            'deletedId' => $request->post('playerTeamId')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validatePlayerTeamId(collect(['playerTeamId' => $request->post('id')]));
        if($validation !== true)
            return back()->withErrors($validation);
        
        PlayerTeam::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Player restored successfully.');
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'playerTeamId' => 'required|numeric|exists:player_team,id',
            'positionId' => 'required|numeric|exists:positions,id',
            'shirtNumber' => ['required', 'numeric', Rule::unique('player_team', 'shirt_number')->ignore($request->post('playerTeamId')), 'gte:0'],
            'contractStart' => 'required|date'
        ]);
        if($validation->stopOnFirstFailure()->fails())
            return $validation;
        return true;
    }

    private function validatePlayerTeamId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'playerTeamId' => 'numeric|exists:player_team,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateTeamId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'teamId' => 'numeric|exists:teams,id',
            
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'positionId' => 'required|numeric|exists:positions,id',
            'shirtNumber' => 'required|numeric|unique:player_team,shirt_number|gte:0',
            'contractStart' => 'required|date',
            'playerId' => 'required|numeric|unique:player_team,player_id|exists:players,id',
            'teamId' => 'required|numeric|exists:teams,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
