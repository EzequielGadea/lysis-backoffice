<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Models\Teams\Manager;
use App\Models\Whereabouts\Country;

class ManagerController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Manager::create([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'country_id' => $request->post('countryId')
        ]);
        return back()->with('statusCreate', 'Manager created succesfuly');
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Managers::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Manager restored succesfuly');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Manager::find($request->post('id'))->update([
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthDate'),
            'country_id' => $request->post('countryId')
        ]);
        return back()->with([
            'statusUpdate' => 'Manager updated succesfuly, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'numeric|exists:managers'
        ]);
        if($validation->fails())
            return back()->withErrors($validation);
        Manager::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Manager deleted succesfuly.',
            'deleteId' => $request->post('id')
        ]);
    }

    public function show()
    {
        return view('managerManagement')->with([
            'managers' => Manager::all(),
            'countries' => Country::all()
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();
        
        return view('managerUpdate')->with([
            'manager' => Manager::find($id),
            'countries' => Country::all()
        ]);
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'birthDate' => 'required|date|before:today',
            'countryId' => 'required|exists:countries,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
        
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:managers',
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'birthDate' => 'required|date',
            'countryId' => 'required|numeric|exists:countries,id'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:managers'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
