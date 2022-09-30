<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Models\Client;
use App\Models\SubscriptionType;

class UserController extends Controller
{
    public function create(CreateUserRequest $request) 
    {
        $client = new Client([
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthdate'),
            'subscription_id' => $request->post('subscriptionId')
        ]);
        $user = new User([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password'))
        ]);

        try {
            DB::transaction(function () use ($client, $user){
                $client->save();
                $client->user()->save($user);
            });
        }
        catch (QueryException $e) {
            return back()->with('statusCreate', 'Couldn\'t create user. If this issue persists please contact the developer team.');
        }

        return back()->with('statusCreate', "User ".$request->post('name')." ".$request->post('surname')." created succesfully.");
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if($validation !== true)
            return back()->withErrors($validation);
        
        $user = User::find($request->post('id'));

        try {
            DB::transaction(function () use ($user, $request) {
                $user->update([
                    'name' => $request->post('name'),
                    'email' => $request->post('email')
                ]);
                if(!empty($request->post('password')))
                    $user->update([
                        'password' => Hass::make($request->post('password'))
                    ]);
                
                $user->client->update([
                    'surname' => $request->post('surname'),
                    'birth_date' => $request->post('birthdate'),
                    'subscription_id' => $request->post('subscription')
                ]);
            });
        } catch (QueryExcpetion $e) {
            return view('updateUser')->with('statusUpdate', 'Couldn\'t update user. If this issue persists please contact the developer team.');
        }

        return back()->with('statusUpdate', 'User updated succesfully. You will soon be redirected back.')->with('isRedirected', 'true');
    }

    public function delete(Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'userId' => 'required|numeric|exists:users,id'
        ]);

        if($validation->fails())
            return back()->withErrors($validation);

        try {
            DB::transaction(function () use ($request) {
                User::find($request->post('userId'))->client()->delete();
                User::destroy($request->post('userId'));
            });
        }
        catch (QueryExcpetion $e) {
            return Redirect::back()->with('statusDelete', 'Could not delete user.');
        }

        return Redirect::back()->with('statusDelete', 'User deleted succesfully');
    }

    public function show() 
    {
        return view('userManagement')->with('users', 
            DB::table('users')
            ->join('clients', 'users.client_id', '=', 'clients.id')
            ->join('subscription_types', 'subscription_types.subscription_id', '=', 'clients.subscription_id')
            ->where('users.deleted_at', '=', null)
            ->select('users.id', 'users.client_id', 'users.name', 'users.email', 'clients.surname', 
                'clients.birth_date', 'subscription_types.type', 'users.created_at', 'users.updated_at', 'users.email_verified_at')
            ->get()
        )->with('subscriptions', SubscriptionType::all());
    }

    public function showUpdate($id)
    {
        $validation = Validator::make(['id' => $id], [
            'id' => 'numeric|exists:users,id'
        ]);

        if($validation->fails())
            return back();

        return view('userUpdate')->with('user', 
            DB::table('users')
            ->join('clients', 'users.client_id', '=', 'clients.id')
            ->join('subscription_types', 'subscription_types.subscription_id', '=', 'clients.subscription_id')
            ->select('users.id', 'users.client_id', 'users.name', 'users.email', 'clients.surname', 'clients.birth_date', 'subscription_types.type')
            ->where('users.id', '=', $id)
            ->get()
            ->first()
        )->with('subscriptions', SubscriptionType::all());
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:users,id',
            'name' => 'required',
            'surname' => 'required',
            'birthdate' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->post('id'))],
            'subscription' => 'required|exists:subscriptions,id',
            'password' => 'nullable|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
        ]);
        if($validation->stopOnFirstFailure()->fails())
            return $validation;

        return true;
    }
}
