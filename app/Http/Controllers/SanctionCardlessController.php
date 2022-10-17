<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sanctions\SanctionCardless as Cardless;

class SanctionCardlessController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)    
            return back()->withErrors($validation);
        
        Cardless::create([
            'description' => $request->post('description')
        ]);
        return back()->with('statusCreate', 'Card created successfully.');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Cardless::find($request->post('id'))->update([
            'description' => $request->post('description')
        ]);
        return back()->with([
            'statusUpdate' => 'Cardless sanction updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back()->withErrors($validation);

        return view('sanctionCardlessUpdate')->with('sanction', Cardless::find($id));
    }

    public function show()
    {
        return view('sanctionCardlessManagement')->with('sanctions', Cardless::all());
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

        Cardless::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Sanction deleted successfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
    
        Cardless::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Sanction restored successfully.');
    }

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'numeric|exists:sanction_cardlesses'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:sanction_cardlesses',
            'description' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'description' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
