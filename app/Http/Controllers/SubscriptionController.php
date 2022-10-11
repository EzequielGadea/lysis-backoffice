<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Models\Users\Subscription;

class SubscriptionController extends Controller
{
    public function create(Request $request) 
    {
        $validation = $this->validateCreation($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Subscription::create([
            'type' => $request->post('type'),
            'description' => $request->post('description'),
            'price' => $request->post('price')
        ]);
        return back()->with('statusCreate', 'Subscription created succesfuly');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Subscription::find($request->post('id'))->update([
            'type' => $request->post('type'),
            'description' => $request->post('description'),
            'price' => $request->post('price')
        ]);
        return back()->with([
            'statusUpdate' => 'Subscription updated succesfuly, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function show()
    {
        return view('subscriptionManagement')->with('subscriptions', Subscription::all());
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if($validation !== true)
            return back();

        return view('subscriptionUpdate')->with('subscription', Subscription::find($id));
    }

    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);

        Subscription::destroy($request->post('id'));
        return back()->with([
            'statusDelete' => 'Subscription deleted succesfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        Subscription::withTrashed()
            ->find($request->post('id'))
            ->restore();
        return back()->with('statusRestore', 'Subscription restored succesfuly.');
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'type' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|integer|gte:0'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:susbcriptions',
            'type' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|integer|gte:0'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }

    private function validateId($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'numeric|exists:subscriptions'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}