<?php

namespace App\Http\Requests\TeamMark;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateTeamMarkRequest extends FormRequest
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
            'team' => 'bail|required|numeric|exists:teams,id',
            'player' => [
                'required',
                'numeric',
                Rule::exists('player_team', 'player_id')->where(function ($query) {
                    $query->where('team_id', Request::get('team'));
                })
            ],
            'markValue' => 'required|numeric'
        ];
    }
}
