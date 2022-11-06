<?php

namespace App\Http\Requests\Results\ByPoints\Individual;

use App\Rules\IsPlayerLocalOrVisitor;
use Illuminate\Foundation\Http\FormRequest;
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
            'points' => 'required|integer|min:1',
            'isInFavor' => 'required|boolean',
            'player' => [
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
                Rule::unique('by_point_player_local')->where(function ($query) {
                    $query->where('event_id', $this->route('result')->event->id);
                }),
                Rule::unique('by_point_player_local')->where(function ($query) {
                    $query->where('by_point_id', $this->route('result')->id);
                }),
                Rule::unique('by_point_player_visitor')->where(function ($query) {
                    $query->where('event_id', $this->route('result')->event->id);
                }),
                Rule::unique('by_point_player_visitor')->where(function ($query) {
                    $query->where('by_point_id', $this->route('result')->id);
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'minute.unique' => 'That player, or another player has already scored at minute ' . $this->minute . '.',
        ];
    }
}
