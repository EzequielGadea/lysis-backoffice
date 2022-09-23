<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Models\Client;
use App\Models\SubscriptionType;

class UserController extends Controller
{
    public function create(CreateUserRequest $request) 
    {
        try {
            return $this->createUser($request);
        }
        catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function delete(Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'userId' => 'required'
        ]);

        if(User::find($request->post('userId')) == null)
            return redirect()->route('userManagement')->with('statusDelete', 'User of ID: '.$request->post('userId').' does not exist');

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

    private function createUser($request) 
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


}
