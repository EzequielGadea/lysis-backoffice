<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateAdRequest;
use App\Models\Ad;
use App\Models\Tag;
use App\Models\Value;

class AdController extends Controller
{

    public function create(CreateAdRequest $request)
    {
        $tagValues = collect([
            'firstTag' => [
                'tag_id' => $request->post('tagOneId'),
                'value' => $request->post('valueTagOne')
            ],
            'secondTag' => [
                'tag_id' => $request->post('tagTwoId'),
                'value' => $request->post('valueTagTwo')
            ],
            'thirdTag' => [
                'tag_id' => $request->post('tagThreeId'),
                'value' => $request->post('valueTagThree')
            ]
        ]);

        try {
            DB::transaction(function () use ($request, $tagValues) {
                $ad = Ad::create([
                    'path' => $request->post('path'),
                    'views_hired' => $request->post('viewsHired'),
                    'location' => $request->post('location'),
                    'link' => $request->post('link')
                ]);
                $tagValues->map(function ($item) use ($ad) {
                    $value = Value::create([
                        'value' => $item['value'],
                        'tag_id' => $item['tag_id']
                    ]);
                    $ad->values()->save($value);
                });                
            });
        } catch (QueryExcpetion $e) {
            return back()->with('statusCreate', 'Couldn\'t create ad.');
        }

        return back()->with('statusCreate', 'Ad created succesfully');
    }

    public function show()
    {
        return view('adManagement')->with('ads', Ad::all())
        ->with('tagsValues', 
            DB::table('ads')
            ->join('ad_value', 'ads.id', '=', 'ad_value.ad_id')
            ->join('values', 'ad_value.value_id', '=', 'values.id')
            ->join('tags', 'values.tag_id', '=', 'tags.id')
            ->select('ads.id', 'tags.name', 'values.value')
            ->get()
        )->with('tags', Tag::all());
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:ads',
            'link' => 'required',
            'path' => ['required', Rule::unique('ads')->ignore($request->post('id'))],
            'viewsHired' => 'required|numeric|gte:1',
            'currentViews' => 'required|numeric|gte:0',
            'tagOneId' => 'required|numeric|exists:tags,id',
            'valueTagOne' => 'required',
            'tagTwoId' => 'required|numeric|exists:tags,id',
            'valueTagTwo' => 'required',
            'tagThreeId' => 'required|numeric|exists:tags,id',
            'valueTagThree' => 'required'
        ]);
        if($validation->stopOnFirstFailure()->fails())
            return back()->withErrors($validation);

        $tagValues = [
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
    
        try {
            DB::transaction(function () use ($request, $tagValues) {
                $ad = Ad::find($request->post('id'))->update([
                    'link' => $request->post('link'),
                    'path' => $request->post('path'),
                    'views_hired' => $request->post('viewsHired'),
                    'current_views' => $request->post('currentViews')
                ]);
                $values = Ad::find($request->post('id'))->values()->get();
                $values->map(function ($item, $key) use ($tagValues) {
                    $item->update($tagValues[$key]);
                });             
            });
        } catch (QueryExcpetion $e) {
            return back()->with('statusUpdate', 'Couldn\'t update ad.');
        }
    
        return back()->with('statusUpdate', 'Ad updated succesfully, you will soon be redirected.')->with('isRedirected', 'true');
   
    }

    public function edit($id)
    {
        $validation = Validator::make(['id' => $id], [
            'id' => 'numeric|exists:ads'
        ]);
        if($validation->fails())
            return back();

        return view('adUpdate')
            ->with('ad', Ad::find($id))
            ->with('adTags', Ad::find($id)->values()->get())
            ->with('tags', Tag::all());
    }

    public function delete(Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:ads'
        ]);
        if($validation->fails())
            return back()->withErrors($validation);

        Ad::destroy($request->post('id'));

        return back()->with('statusDelete', 'Ad deleted succesfully.');
    }
}
