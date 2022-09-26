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
        try {
            return $this->store($request);
        }
        catch (QueryException $e) {
            return $e->getMessage();
        }
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
                
                $user->client->update([
                    'surname' => $request->post('surname'),
                    'birth_date' => $request->post('birthdate'),
                    'subscription_id' => SubscriptionType::firstWhere('type', $request->post('subscription'))->subscription_id
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
            ->select('users.id', 'users.client_id', 'users.name', 'users.email', 'clients.surname', 'clients.birth_date', 'subscription_types.type')
            ->get()
        );
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
        );
    }

    private function store($request) 
    {
        $client = new Client([
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthdate'),
            'subscription_id' => SubscriptionType::firstWhere('type', $request->post('subscription'))->subscription_id
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
            return [
                "result" => "Couldn't create user.",
                "trace" => $e->getMessage()
            ];
        }

        return redirect('userManagement')->with('statusCreate', "User ".$request->post('name')." ".$request->post('surname')." created succesfully.");
    }

    private function validateUpdate($request)
    {
        $validateId = Validator::make(['id' => $request->post('id')], [
            'id' => 'numeric|exists:users,id'
        ]);

        if($validateId->fails())
            return $validateId;

        $validation = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'birthdate' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore(User::find($request->post('id'))->id)],
            'subscription' => 'required'
        ]);

        if($validation->fails())
            return $validation;

        return true;
    }
}
