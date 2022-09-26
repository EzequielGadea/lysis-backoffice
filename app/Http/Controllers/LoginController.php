<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin;

class LoginController extends Controller
{
    public function authenticate(Request $request) 
    {
        $validation = $this->validateAuthentication($request);
        if($validation !== true)
            return $validation;
        
        if (!Auth::attempt([
            'email' => $request->post('email'),
            'password' => $request->post('password')
        ])) 
            return Redirect::back()->withErrors([
                'statusLogin' => 'Credentials don\'t match any registered admin.'
            ]);

        return redirect()->route('userManagement');
    }

    public function logout() 
    {
        Auth::logout();
    }

    private function validateAuthentication($request) 
    {
        $validator = Validator::make($request -> all(), [
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if($validator -> fails())
            return Redirect::back()->withErrors($validator->errors());

        return true;
    }
}
