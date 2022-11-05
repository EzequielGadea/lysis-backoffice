<?php

namespace App\Http\Requests\Results\ByPoints\Team;

use App\Models\Players\PlayerTeam;
use App\Models\Results\ByPoint;
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
            'team' => 'bail|required|integer|exists:teams,id',
            'player' => [
                'required',
                'integer',
                Rule::exists('player_team', 'player_id')->where(function ($query) {
                    $query->where('team_id', Request::get('team'));
                }),
            ],
            'minute' => [
                'required',
                'integer',
                'min:0',
                'max:999',
                Rule::unique('by_point_event_player_team')->where(function ($query) {
                    $eventPlayerTeam = PlayerTeam::where([
                        ['team_id', Request::get('team')],
                        ['player_id', Request::get('player')],
                    ])
                        ->latest('contract_start')
                        ->first()
                        ->events
                        ->firstWhere('event_id', $this->route('result')->event->id);
                    $query->where('event_player_team_id', $eventPlayerTeam->id);
                }),
            ],
            'points' => 'required|integer|min:0|max:999',
            'isInFavor' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'minute.unique' => 'The player\'s already scored at minute ' . $this->minute
        ];
    }
}
