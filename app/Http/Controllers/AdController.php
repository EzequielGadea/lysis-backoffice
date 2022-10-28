<?php

namespace App\Http\Controllers;

use App\Models\Ads\Ad;
use App\Models\Ads\Tag;
use App\Models\Ads\Value;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\Ad\UpdateAdRequest;
use App\Http\Requests\Ad\CreateAdRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdController extends Controller
{

    public function create(CreateAdRequest $request)
    {
        $tagValues = $this->tagValuesToArray($request);

        try {
            DB::transaction(function () use ($request, $tagValues) {
                $ad = Ad::create([
                    'image' => $this->storeImage($request->file('image')),
                    'views_hired' => $request->post('viewsHired'),
                    'location' => $request->post('location'),
                    'link' => $request->post('link'),
                ]);
                foreach ($tagValues as $value) {
                    $values = Value::create([
                        'value' => $value['value'],
                        'tag_id' => $value['tag_id']
                    ]);
                    $ad->values()->save($values);
                }
            });                
        } catch (QueryException $e) {
            return back()->with('statusCreate', 'Couldn\'t create ad.');
        }

        return back()->with('statusCreate', 'Ad created succesfully');
    }

    public function show()
    {
        return view('adManagement', [
            'ads' => Ad::all(),
            'tagsValues' => 
                DB::table('ads')
                ->join('ad_value', 'ads.id', '=', 'ad_value.ad_id')
                ->join('values', 'ad_value.value_id', '=', 'values.id')
                ->join('tags', 'values.tag_id', '=', 'tags.id')
                ->select('ads.id', 'tags.name', 'values.value')
                ->get(),
            'tags' => Tag::all()
        ]);
    }

    public function update(UpdateAdRequest $request)
    {    
        $ad = Ad::find($request->post('id'));
        $tagValues = $this->tagValuesToArray($request);
        try {
            DB::transaction(function () use ($request, $tagValues, $ad) {
                $ad->update([
                    'link' => $request->post('link'),
                    'views_hired' => $request->post('viewsHired'),
                    'current_views' => $request->post('currentViews')
                ]);
                $values = $ad->values()->get();
                $values->map(function ($item, $key) use ($tagValues) {
                    $item->update($tagValues[$key]);
                });
                if ($request->file('image') !== null)
                    $ad->update([
                        'image' => $this->changeImage($ad->image, $request->file('image'))
                    ]);
            });
        } catch (QueryException $e) {
            return back()->with('statusUpdate', 'Couldn\'t update ad.');
        }
    
        return back()->with([
            'statusUpdate' => 'Ad updated succesfully, you will soon be redirected.',
            'isRedirected' => 'true'
        ]);
    }

    public function edit($id)
    {
        $validation = Validator::make(['id' => $id], [
            'id' => 'numeric|exists:ads'
        ]);
        if ($validation->fails())
            return back();

        return view('adUpdate', [
            'ad' => Ad::find($id),
            'adTags' => Ad::find($id)->values()->get(),
            'tags' => Tag::all()
        ]);
    }

    public function delete(Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:ads'
        ]);
        if ($validation->fails())
            return back()->withErrors($validation);

        Ad::destroy($request->post('id'));

        return back()->with([
            'statusDelete' => 'Ad deleted succesfully.',
            'deletedId' => $request->post('id')
        ]);
    }

    public function restore(Request $request)
    {
        $validation = $this->validateRestore($request);
        if ($validation !== true)
            return back()->withErrors($validation);

        Ad::withTrashed()
            ->find($request->post('id'))
            ->restore();

        return back()->with('statusRestore', 'Ad restored succesfully.');
    }

    private function changeImage($oldImage, $newImage)
    {
        File::delete($this->imagesFolder . '/' . $oldImage);
        return $this->storeImage($newImage);
    }

    private function storeImage($file)
    {
        $fileName = Str::random(32) . '.' . $file->extension();
        $file->move($this->imagesFolder, $fileName);
        return $fileName;
    }

    private function validateRestore($request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:ads'
        ]);
        if ($validation->fails())
            return $validation;
        return true;
    }

    private function tagValuesToArray($request) {
        return [
            [
                'tag_id' => $request->post('tagOneId'),
                'value' => $request->post('valueTagOne')
            ],
            [
                'tag_id' => $request->post('tagTwoId'),
                'value' => $request->post('valueTagTwo')
            ],
            [
                'tag_id' => $request->post('tagThreeId'),
                'value' => $request->post('valueTagThree')
            ]
        ];
    }
}
