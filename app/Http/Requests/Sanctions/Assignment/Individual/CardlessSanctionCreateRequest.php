<?php

namespace App\Http\Requests\Sanctions\Assignment\Individual;

use App\Rules\IsPlayerLocalOrVisitor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardlessSanctionCreateRequest extends FormRequest
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
            'sanction' => 'required|integer|exists:sanction_cardlesses,id',
            'set' => [
                'nullable',
                'integer',
                Rule::exists('sets', 'id')->where(function ($query) {
                    $query->where('by_set_id', $this->route('event')->result()->id);
                }),
            ],
            'player' => [
                'bail',
                'required',
                'integer',
                'exists:players,id',
                new IsPlayerLocalOrVisitor,
            ],
            'minute' => [
                'required',
                'integer',
                'min:0',
                'max:999',
                Rule::unique('player_local_sanction_cardless')->where(function ($query) {
                    $query->where('event_id', $this->route('event')->id);
                }),
                Rule::unique('player_visitor_sanction_cardless')->where(function ($query) {
                    $query->where('event_id', $this->route('event')->id);
                }),
            ]
        ];
    }
}
