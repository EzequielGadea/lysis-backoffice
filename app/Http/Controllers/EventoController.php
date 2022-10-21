<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if($validation->fails())
            return back()->withErrors($validation);
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'startDate' => 'required|date',
            'venue_id' => 'required|numeric|exists:venues,id',
            'isByTeams' => 'required|boolean'
        ]);
    }
}
