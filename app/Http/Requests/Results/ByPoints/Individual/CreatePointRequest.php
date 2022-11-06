<?php

namespace App\Http\Requests\Results\ByPoints\Individual;

use App\Rules\IsPlayerLocalOrVisitor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

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
                function ($attribute, $value, $fail) {
                    $isPointInMinuteUniqueLocal = DB::table('by_point_player_local')->where([
                        ['minute', $value],
                        ['by_point_id', $this->route('result')->event->id],
                    ])->exists();

                    $isPointInMinuteUniqueVisitor = DB::table('by_point_player_visitor')->where([
                        ['minute', $value],
                        ['by_point_id', $this->route('result')->event->id],
                    ])->exists();

                    if ($isPointInMinuteUniqueLocal || $isPointInMinuteUniqueVisitor) {
                        $fail('Another player has already scored at minute ' . $value . '.');
                    }

                },
                function ($attribute, $value, $fail) {
                    $isPlayerMinuteUniqueLocal = DB::table('by_point_player_visitor')->where([
                        ['minute', $value],
                        ['event_id', $this->route('result')->event->id],
                    ])->exists();

                    $isPlayerMinuteUniqueVisitor = DB::table('by_point_player_visitor')->where([
                        ['minute', $value],
                        ['event_id', $this->route('result')->event->id],
                    ])->exists();

                    if ($isPlayerMinuteUniqueLocal || $isPlayerMinuteUniqueVisitor) {
                        $fail('Another player has already scored at minute ' . $value . '.');
                    }

                },
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
