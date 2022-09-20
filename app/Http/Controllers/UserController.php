<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function Create(Request $request) {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return $validation;

        try {
            return $this->createUser($request);
        }
        catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    private function validateCreation($request) {
        $validator = Validator::make($request -> all(),[
            'name' => 'required',
            'surname' => 'required',
            'birthdate' => 'required',
            'email' => 'required|email|unique:admins',
            'subscription' => 'required',
            'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
        ]);

        if($validator->fails()) 
            return redirect()->back()->withErrors($validator);

        return true;
    }

    private function createUser($request) {
        $client = new Client([
            'surname' => $request->post('surname'),
            'birthdate' => $request->post('birthdate'),
            'subscription_id' => Subscription::firstWhere('type', $request->post('subscription'))->id
        ]);

        $user = new User([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password'))
        ]);

        $client->user()->save($user);
        try {
            DB::transaction(function () use ($client, $user){
                $client->save();
                $client->user()->save($user);
            });
        } 
        catch (QueryException $e) {
            return [
                "result" => "Couldn't create user.",
                "trace" => $e->getMessage()
            ];
        }

        return [
            "result" => "User registered succesfully."
        ];
    }
}
