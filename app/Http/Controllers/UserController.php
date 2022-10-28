<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Models\Users\Client;
use App\Models\Users\Subscription;

class UserController extends Controller
{
    private $profilePicturesFolder = 'images';

    public function create(CreateUserRequest $request) 
    {
        $client = new Client([
            'surname' => $request->post('surname'),
            'birth_date' => $request->post('birthdate'),
            'subscription_id' => $request->post('subscriptionId'),
            'profile_picture' => $this->storeProfilePicture($request->file('profilePicture'))
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
                if(! empty($request->post('password')))
                    $user->update([
                        'password' => Hash::make($request->post('password'))
                    ]);
                
                $user->client->update([
                    'surname' => $request->post('surname'),
                    'birth_date' => $request->post('birthdate'),
                    'subscription_id' => $request->post('subscription')
                ]);
                if($request->file('profilePicture') !== NULL)
                    $user->client->update([
                        'profile_picture' => $this->updateProfilePicture($user->client->picture, $request->file('profilePicture'))
                    ]);
            });
        } catch (QueryException $e) {
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
        catch (QueryException $e) {
            return Redirect::back()->with('statusDelete', 'Could not delete user.');
        }

        return Redirect::back()->with([
            'statusDelete' => 'User deleted succesfully',
            'deletedId' => $request->post('userId')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateRestore($request);
        if($validation !== true)
            return back()->withErrors($validation);

        try {
            DB::transaction(function () use ($request) {
                User::withTrashed()
                    ->where('id', $request->post('id'))
                    ->restore();
                User::withTrashed()
                    ->find($request->post('id'))
                    ->client()
                    ->restore();
            });
        } catch (QueryException $e) {
            return back()->with('statusRestore', 'Couldn\'t restore user.');
        }
        return back()->with('statusRestore', 'User restored succesfully.');
    }

    public function show() 
    {
        return view('userManagement', [
            'users' => User::all(),
            'subscriptions' => Subscription::all()
        ]);
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
            ->join('subscriptions', 'subscriptions.id', '=', 'clients.subscription_id')
            ->select('users.id', 'users.client_id', 'users.name', 'users.email', 'clients.surname', 'clients.birth_date', 'subscriptions.type')
            ->where('users.id', '=', $id)
            ->get()
            ->first()
        )->with('subscriptions', Subscription::all());
    }

    private function updateProfilePicture($oldPicture, $newPicture)
    {
        File::delete($this->profilePicturesFolder . '/' . $oldPicture);
        return $this->storeProfilePicture($newPicture);
    }

    private function storeProfilePicture($file)
    {
        $fileName = Str::random(32) . '.' . $file->extension();
        $file->move($this->profilePicturesFolder, $fileName);
        return $fileName;
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
            'password' => 'nullable|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
            'profilePicture' => 'nullable|image|max:5000'
        ]);
        if($validation->stopOnFirstFailure()->fails())
            return $validation;

        return true;
    }

    private function validateRestore($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:users'
        ]);
        if($validation->fails())
            return $validation;
        return true;
    }
}
