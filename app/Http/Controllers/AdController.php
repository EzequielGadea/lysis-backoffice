<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateAdRequest;
use App\Models\Ad;
use App\Models\Tag;
use App\Models\Value;

class AdController extends Controller
{
    public function create(CreateAdRequest $request)
    {
        try {
            $ad = Ad::create([
                'path' => $request->post('path'),
                'views_hired' => $request->post('viewsHired'),
                'location' => $request->post('location'),
                'link' => $request->post('link')
            ]);
        } catch (QueryExcpetion $e) {
            return back()->with('statusCreate', 'Couldn\'t create ad.');
        }
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
}
