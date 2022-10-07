<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function create(Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'type' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|integer'
        ]);
        if($validation->fails())
            return back()->withErrors($validation);

        try {
            DB::transaction(function () use ($request) {
                $subscription = Subscription::create([
                    'type' => $request->post('type'),
                    'description' => $request->post('description'),
                    'price' => $request->post('price')
                ]);
            });
        } catch (QueryException $e) {
            return back()->with('statusCreate', 'Couldn\'t create subscription.');
        }
        return back()->with('statusCreate', 'Subscription created succesfuly');
    }

    public function show()
    {
        return view('subscriptionManagement')->with('subscriptions', Subscription::all());
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'type' => 'required|max:225',
            'description' => 'required|max:225',
            'price' => 'required|integer'
        ]);
        if($validation->fails())
            return back()->withErrors($validation);

        try {
            $subscription = Subscription::find($request->post('id'))->update([
                'type' => $request->post('type'),
                'description' => $request->post('description'),
                'price' => $request->post('price')
            ]);
        } catch (QueryException $e) {
            return back()->with('statusUpdate', 'Couldn\'t update subscription.');
        }
        return back()->with([
            'statusUpdate' => 'Subscription updated succesfuly, you will soon be redirected',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = Validator::make(['id' => $id], ['id' => 'numeric|exists:subscriptions']);
        if($validation->fails())
            return back()->withErrors($validation);

        return view('subscriptionUpdate')->with('subscription', Subscription::find($id));
    }

    public function delete(Request $request)
    {
        $validation = Validator::make($request->all(), ['id' => 'numeric|exists:subscriptions']);

        Subscription::destroy($request->post('id'));

        return back()->with([
            'statusDelete' => 'Subscription deleted succesfully.',
            'deletedId' => $request->post('id')
        ]);
    }
}