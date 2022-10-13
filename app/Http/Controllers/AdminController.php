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
use App\Models\Users\Admin;


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
        } catch (QueryException $e) {
            return back()->with('statusCreate', 'Couldn\'t create admin.');
        }

        return back()->with('statusCreate', 'Admin created successfully.');
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
        
        return back()->with([
            'statusUpdate' => 'Admin updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Admin::destroy($request->post('id'));

        return back()->with([
            'statusDelete' => 'Admin deleted successfully',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Admin::withTrashed()
            ->find($request->post('id'))
            ->restore();

        return back()->with('statusRestore', 'Admin restored successfully.');
    }

    public function show() 
    {
        return view('adminManagement')->with('admins', 
            DB::table('admins')
            ->where('deleted_at', '=', null)
            ->select('id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at')
            ->get()
        );
    }

    public function showUpdate($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();

        return view('adminUpdate')->with('admin', Admin::find($id));
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:admins,id',
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($request->post('id'))],
            'password' => 'nullable|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
        ]);
        if($validation->stopOnFirstFailure()->fails())
            return $validation;

        return true;
    }

    private function validateRestore($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:admins'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:admins'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
