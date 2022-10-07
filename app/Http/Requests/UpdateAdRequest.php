<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
        ];
    }
}
