<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Common\Sport;
use App\Models\Common\League;

class SportController extends Controller
{
    private $profilePicturesFolder = 'images';

    public function create(Request $request)
    {
        $validation = $this->validateCreation($request);
        if ($validation !== true)
            return back()->withErrors($validation);
        
        Sport::create([
            'name' => $request->post('name'),
            'picture' => $this->storePicture($request->file('picture'))
        ]);
        return back()->with('statusCreate', 'Sport created successfully.');
    }

    public function update(Request $request)
    {
        $validation = $this->validateUpdate($request);
        if ($validation !== true)
            return back()->withErrors($validation);

        $sport = Sport::find($request->post('id'));
        $sport->update([
            'name' => $request->post('name')
        ]);
        if ($request->file('picture') !== null)
            $sport->update([
                'picture' => $this->changePicture($sport->picture, $request->file('picture'))
            ]);

        return back()->with([
            'statusUpdate' => 'Sport updated successfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = $this->validateId(collect(['id' => $id]));
        if ($validation !== true)
            return back();
        
        return view('sportUpdate', [
            'sport' => Sport::find($id)
        ]);
    }

    public function show()
    {
        return view('sportManagement', [
            'sports' => Sport::all()
        ]);
    }

    /**
     *  Chequear esto cuando creemos la gestion de ligas porque cuando
     * elimino un deporte elimino sus ligas.
     */
    public function delete(Request $request)
    {
        $validation = $this->validateId($request);
        if ($validation !== true)
            return back()->withErrors($validation);
        
        try {
            DB::transaction(function () use ($request) {
                League::where('sport_id', $request->post('id'))->delete();
                Sport::destroy($request->post('id'));
            });
        } catch (QueryException $e) {
            return back()->with('statusDelete', 'Unable to delete sport right now.');
        }   
        return back()->with([
            'statusDelete' => 'Sport deleted successfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateId($request);
        if ($validation !== true)
            return back()->withErrors($validation);

        try {
            DB::transaction(function () use ($request) {
                League::withTrashed()
                    ->where('sport_id', $request->post('id'))
                    ->restore();
                Sport::withTrashed()
                    ->find($request->post('id'))
                    ->restore();
            });
        } catch (QueryException $e) {
            return back()->with('statusRestore', 'Unable to restore sport right now.');
        }   
        return back()->with('statusRestore', 'Sport restored successfully.');
    }

    private function changePicture($oldPicture, $newPicture)
    {
        File::delete($this->profilePicturesFolder . '/' . $oldPicture);
        return $this->storePicture($newPicture);
    }

    private function storePicture($file)
    {
        $fileName = Str::random(32) . '.' . $file->extension();
        $file->move($this->profilePicturesFolder, $fileName);
        return $fileName;
    }

    private function validateId($collection)
    {
        $validation = Validator::make($collection->all(), [
            'id' => 'numeric|exists:sports'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }

    private function validateUpdate($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:sports',
            'name' => 'required|string|max:255'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }

    private function validateCreation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }
}
