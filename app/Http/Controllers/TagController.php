<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Tag;

class TagController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Tag::create([
            'name' => $request->post('name')
        ]);
        
        return back()->with('statusCreate', 'Tag created succesfully.');
    }

    public function delete(Request $request)
    {
        $validation = $this->validateDeletion($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Tag::destroy($request->post('id'));

        return back()->with([
            'statusDelete' => 'Tag deleted succesfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateRestore($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Tag::withTrashed()
            ->where('id', $request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Tag restored succesfully.');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Tag::find($request->post('id'))->update([
            'name' => $request->post('name')
        ]);

        return back()->with([
            'statusUpdate' => 'Tag updated succesfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = Validator::make(['id' => $id], [
            'id' => 'numeric|exists:tags'
        ]);
        if($validation->fails())
            return back();
        return view('tagUpdate')->with('tag', Tag::find($id));
    }

    public function show()
    {
        return view('tagManagement')->with('tags', Tag::all());
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('tags')->whereNull('deleted_at')]
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateDeletion($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:tags'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:tags',
            'name' => ['required', 
                Rule::unique('tags')
                ->ignore($request->post('id'))
            ]
        ]);
        if($validation->stopOnFirstFailure()->fails())
            return $validation;
        return true;
    }

    private function validateRestore($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:tags'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
