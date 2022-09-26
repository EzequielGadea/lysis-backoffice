<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateAdminRequest;
use App\Models\Admin;


class AdminController extends Controller
{
    public function create(CreateAdminRequest $request)
    {
        try {
            Admin::create([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'password' => Hash::make($request->post('password'))
            ]);

            return back()->with('statusCreate', 'Admin created succesfully.');
        } catch (QueryException $e) {
            return back()->with('statusCreate', 'Couldn\'t create admin.');
        }
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Admin::find($request->post('id'))->update([
            'name' => $request->post('name'),
            'email' => $request->post('email')
        ]);
        if(!empty($request->post('password')))
            Admin::find($request->post('id'))->update([
                'password' => Hash::make($request->post('password'))
            ]);
        
        return back()->with('statusUpdate', 'Admin updated succesfully, you will soon be redirected.')->with('isRedirected', 'true');
    }

    public function delete(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:admins,id'
        ]);
        if($validation->fails())
            return back()->withErrors($validation);
        
        Admin::destroy($request->post('id'));

        return back()->with('statusDelete', 'Admin deleted succesfully');
    }

    private function validateUpdate($request)
    {
        $validateId = $this->validateId($request->post('id'));
        if($validateId !== true)
            return back()->withErrors($validateId);
        
        $validation = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('admins')->ignore(Admin::find($request->post('id'))->id)],
            'password' => 'nullable|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
        ]);
        if($validation->fails())
            return $validation;

        return true;
    }

    private function validateId($id)
    {
        $validation = Validator::make(['id' => $id], [
            'id' => 'numeric|exists:admins,id'
        ]);
        if($validation->fails())
            return $validateId;

        return true;
    }

    public function show() 
    {
        return view('adminManagement')->with('admins', 
            DB::table('admins')
            ->where('deleted_at', '=', null)
            ->select('id', 'name', 'email')
            ->get()
            );
    }

    public function showUpdate($id)
    {
        $validation = Validator::make(['id' => $id], [
            'id' => 'numeric|exists:admins,id'
        ]);
        if($validation->fails())
            return back();

        return view('adminUpdate')->with('admin', Admin::find($id));
    }
}
