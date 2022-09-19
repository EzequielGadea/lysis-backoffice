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
            "name" => "required",
            "email" => ["required", "email"],
            "password" => "required"
        ]);

        if($validator->fails()) 
            return $validator->errors()->toJson();

        return true;
    }

    private function createUser($request) {
        try {
            User::create([
                "name" => $request -> post("name"),
                "email" => $request -> post("email"),
                "password" => Hash::make($request -> post("password"))
            ]);
        } 
        catch (QueryException $e) {
            return [
                "result" => "Couldn't create admin.",
                "trace" => $e->getMessage()
            ];
        }

        return [
            "result" => "Admin registered succesfully."
        ];
    }
}
