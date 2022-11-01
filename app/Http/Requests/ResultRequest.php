<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResultRequest extends FormRequest
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
            'playerId' => 'required|numeric|exists:player_team,player_id',
            'teamId' => 'nullable|numeric|exists:teams,id',
            'markValue' => 'required_without:points,isInFavor,minute,set|string|max:255',
            'points' => 'required_without:markValue|numeric|gte:1',
            'isInFavor' => 'required_without:markValue|boolean',
            'minute' => 'required_without:markValue|numeric|gte:0',
            'set' => 'required_without:markValue|numeric'
        ];
    }
}
