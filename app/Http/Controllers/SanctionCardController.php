<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sanctions\SanctionCard;

class SanctionCardController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        SanctionCard::create([
            'color' => $request->post('color')
        ]);
        return back()->with('statusCreate', 'Card created successfully.');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        SanctionCard::find($request->post('id'))->update([
            'color' => $request->post('color')
        ]);
        return back()->with([
            'statusUpdate' => 'Card updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back()->withErrors($validation);
        
        return view('sanctionCardUpdate')->with('card', SanctionCard::find($id));
    }

    public function show()
    {
        return view('sanctionCardManagement')->with('cards', SanctionCard::all());
    }

    /**
     * Chequear esto cuando implementemos las sanciones a los jugadores,
     * ya que cuando se elimina una tarjeta se eliminan las sanciones.
     */
    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        SanctionCard::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Card deleted successfully',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        SanctionCard::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Card restored successfully.');
    }

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'required|numeric|exists:sanction_cards'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:sanction_cards',
            'color' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'color' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
