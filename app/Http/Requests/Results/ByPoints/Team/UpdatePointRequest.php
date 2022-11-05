<?php

namespace App\Http\Requests\Results\ByPoints\Team;

use App\Models\Results\ByPointEventPlayerTeam;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePointRequest extends FormRequest
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
            'minute' => [
                'required',
                'integer',
                'min:0',
                'max:999',
                Rule::unique('by_point_event_player_team')->where(function ($query) {
                    $query->where(
                        'event_player_team_id',
                        ByPointEventPlayerTeam::find($this->route('point'))->first()->event_player_team_id
                    );
                }),
            ],
            'points' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'minute.unique' => 'The player\'s already scored at minute ' . $this->minute,
        ];
    }
}
