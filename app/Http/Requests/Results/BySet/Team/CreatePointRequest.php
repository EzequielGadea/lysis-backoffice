<?php

namespace App\Http\Requests\Results\BySet\Team;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'team' => 'bail|required|integer|exists:teams,id',
            'player' => [
                'required',
                'integer',
                Rule::exists('player_team', 'player_id')->where(function ($query) {
                    $query->where('team_id', Request::get('team'));
                })
            ],
            'minute' => 'required|integer|min:0|max:999',
            'points' => 'required|numeric|min:1',
            'isInFavor' => 'required|boolean'
        ];
    }
}
