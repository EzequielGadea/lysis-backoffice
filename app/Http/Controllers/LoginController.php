<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class LoginController extends Controller
{
    public function Authenticate(Request $request) {
        $validation = $this->validateAuthentication($request);
        if($validation !== true)
            return $validation;
        
        return $this->doAuthentication(
            $request->post('email'),
            $request->post('password')
        );
    }

    private function validateAuthentication($request) {
        $validator = Validator::make($request -> all(), [
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if($validator -> fails())
            return $validator->errors()->toJson();

        return true;
    }

    private function doAuthentication($email, $password) {
        $admin = Admin::firstWhere('email', $email);

        if($admin == null)
            return [
                'result' => "$email is not a registered email."
            ];

        if(!Hash::check($password, $admin->password)) 
            return [
                'result' => 'Wrong password.'
            ];

        Auth::login($admin);
        return view('index');
    }
}
