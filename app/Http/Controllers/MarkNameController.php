<?php

namespace App\Http\Controllers;

use App\Models\Common\Criteria;
use App\Models\Common\Unit;
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
            'name' => $request->post('name'),
            'criteria_id' => $request->post('criteriaId'),
            'unit_id' => $request->post('unitId')
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
            'name' => $request->post('name'),
            'criteria_id' => $request->post('criteriaId'),
            'unit_id' => $request->post('unitId')
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
        return view('MarkNameManagement', [
            'markNames' => MarkName::all(),
            'criterias' => Criteria::all(),
            'units' => Unit::all()
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();

        return view('markNameUpdate', [
            'markName' => MarkName::find($id),
            'criterias' => Criteria::all(),
            'units' => Unit::all()
        ]);
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'criteriaId' => 'required|numeric|exists:criterias,id',
            'unitId' => 'required|numeric|exists:units,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:mark_names',
            'name' => 'required|string|max:255',
            'criteriaId' => 'required|numeric|exists:criterias,id',
            'unitId' => 'required|numeric|exists:units,id'
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
