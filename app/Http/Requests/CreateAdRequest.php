<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdRequest extends FormRequest
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
            'link' => 'required|url',
            'path' => 'required|unique:ads',
            'location' => 'required',
            'viewsHired' => 'required|integer|gte:1',
            'tagOneId' => 'required|exists:tags,id',
            'valueTagOne' => 'required',
            'tagTwoId' => 'required|exists:tags,id',
            'valueTagTwo' => 'required',
            'tagThreeId' => 'required|exists:tags,id',
            'valueTagThree' => 'required'
        ];
    }
}
