<?php

namespace App\Http\Requests\Sanctions\Assignment\Team;

use Illuminate\Foundation\Http\FormRequest;

class CardSanctionUpdateRequest extends FormRequest
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
            'sanction' => 'required|integer|exsits:sanction_cards,id',
            'team' => 'bail|required|integer|exists:teams,id',
            'set' => [
                'nullable',
                'integer',
                Rule::exists('sets', 'id')->where(function ($query) {
                    $query->where('by_set_id', $this->route('sanction')->event->result()->id);
                }),
                Rule::requiredIf($this->route('sanction')->event->result()->result_type_id == '3'),
            ],
            'minute' => 'required|integer|min:0|max:999',
            'player' => [
                'required',
                'integer',
                Rule::exists('player_team', 'player_id')->where(function ($query) {
                   $query->where('team_id', $this->team); 
                }),
            ],
        ];
    }
}
