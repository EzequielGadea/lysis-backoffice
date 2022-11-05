<?php

namespace App\Http\Requests\Result\BySet\Individual;

use Illuminate\Foundation\Http\FormRequest;

class CreatePointRequest extends FormRequest
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
            'set' => 'required|integer|exists:sets,id',
            'player' => 'required|integer|exists:players,id',
            'minute' => 'required|integer|min:0|max:999',
            'points' => 'required|integer|min:1',
            'isInFavor' => 'required|boolean',
        ];
    }
}
