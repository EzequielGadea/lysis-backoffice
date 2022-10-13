<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Collection;
use App\Models\Common\Sport;

class SportController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Sport::create([
            'name' => $request->post('name')
        ]);
        return back()->with('statusCreate', 'Sport created successfully.');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Sport::find($request->post('id'))->update([
            'name' => $request->post('name')
        ]);
        return back()->with([
            'statusUpdate' => 'Sport updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();
        
        return view('sportUpdate')->with('sport', Sport::find($id));
    }

    public function show()
    {
        return view('sportManagement')->with('sports', Sport::all());
    }

    /**
     *  Chequear esto cuando creemos la gestion de ligas porque cuando
     * elimino un deporte elimino sus ligas.
     */
    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Sport::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Sport deleted successfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Sport::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Sport restored successfully.');
    }

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'numeric|exists:sports'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:sports',
            'name' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
