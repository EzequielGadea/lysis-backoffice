<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Models\Results\MarkName;

class MarkNameController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        MarkName::create([
            'name' => $request->post('name')
        ]);
        return back()->with('statusCreate', 'Mark name created succesfully');
    }

    public function restore(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:mark_names'
        ]);
        if($validation->fails())
            return back()->withErrors($validation);
        
        MarkName::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Mark name restored succesfully');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);

        MarkName::find($request->post('id'))->update([
            'name' => $request->post('name')
        ]);
        return back()->with([
            'statusUpdate' => 'Mark name updated succesfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)    
            return back()->withErrors($validation);

        MarkName::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Mark name deleted succesfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function show()
    {
        return view('MarkNameManagement')->with('markNames', MarkName::all());
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();

        return view('markNameUpdate')->with('markName', MarkName::find($id));
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

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:mark_names',
            'name' => 'required|string|max:255'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'numeric|exists:mark_names'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
