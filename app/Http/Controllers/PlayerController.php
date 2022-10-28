<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Players\Player;
use App\Models\Whereabouts\Country;

class PlayerController extends Controller
{
    private $profilePicturesFolder = 'images';

    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if ($validation !== true)
            return back()->withErrors($validation);
        
        Player::create([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'height' => $request->post('height'),
            'weight' => $request->post('weight'),
            'country_id' => $request->post('countryId'),
            'picture' => $this->storeProfilePicture($request->file('picture'))
        ]);
        return back()->with('statusCreate', 'Player created succesfully.');
    }
    
    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if ($validation !== true)
            return back()->withErrors($validation);

        $player = Player::find($request->post('id'));
        $player->update([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'height' => $request->post('height'),
            'weight' => $request->post('weight'),
            'country_id' => $request->post('countryId')
        ]);
        if ($request->file('picture') !== null)
            $player->update([
                'picture' => $this->changeProfilePicture($player->picture, $request->file('picture'))
            ]);

        return back()->with([
            'statusUpdate' => 'Player updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if ($validation !== true)
            return back();
        return view('playerUpdate', [
            'player' => Player::find($id),
            'countries' => Country::all()
        ]);
    }

    public function show()
    {
        return view('playerManagement', [
            'players' => Player::all(),
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
        if ($validation !== true)    
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
        if ($validation !== true)
            return back()->withErrors($validation);
        
        Player::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Player restored successfully.');
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

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'numeric|exists:players'
        ]);
        if ($validation->fails())
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
            'countryId' => 'required|numeric|exists:countries,id',
            'picture' => 'nullable|image|max:5000'
        ]);
        if ($validation->fails())
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
            'countryId' => 'required|numeric|exists:countries,id',
            'picture' => 'required|image|max:5000'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }
}
