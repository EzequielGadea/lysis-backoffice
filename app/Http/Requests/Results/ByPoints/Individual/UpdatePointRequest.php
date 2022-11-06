<?php

namespace App\Http\Requests\Results\ByPoints\Individual;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
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
        return false;
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
            'minute' => [
                'required',
                'integer',
                'min:0',
                'max:999',
                /**
                 * Las siguientes funciones validan que dos jugadores no hagan un punto en
                 * el mismo minuto.
                 */
                function ($attribute, $value, $fail) {
                    $pointInMinuteLocal = DB::table('by_point_player_local')->where([
                        ['minute', $value],
                        ['by_point_id', $this->route('point')->result->id],
                    ]);

                    $pointInMinuteVisitor = DB::table('by_point_player_visitor')->where([
                        ['minute', $value],
                        ['by_point_id', $this->route('point')->result->id],
                    ]);

                    if (! $pointInMinuteLocal->count() == 1 || ! $pointInMinuteLocal->first()->by_point_id == request()->route('point')->result->id) {
                        $fail('Another player has already scored at minute ' . $value . '.');
                    }

                    if (! $pointInMinuteVisitor->count() == 1 || ! $pointInMinuteVisitor->first()->by_point_id == request()->route('point')->result->id) {
                        $fail('Another player has already scored at minute ' . $value . '.');
                    }

                },
                function ($attribute, $value, $fail) {
                    $playerMinuteLocal = DB::table('by_point_player_visitor')->where([
                        ['minute', $value],
                        ['event_id', $this->route('point')->event_id],
                    ]);

                    $playerMinuteVisitor = DB::table('by_point_player_visitor')->where([
                        ['minute', $value],
                        ['event_id', $this->route('point')->event_id],
                    ]);

                    if (! $playerMinuteLocal->count() == 1 || ! $playerMinuteLocal->first()->by_point_id == request()->route('point')->result->id) {
                        $fail('Another player has already scored at minute ' . $value . '.');
                    }

                    if (! $playerMinuteVisitor->count() == 1 || ! $playerMinuteVisitor->first()->by_point_id == request()->route('point')->result->id) {
                        $fail('Another player has already scored at minute ' . $value . '.');
                    }

                },
            ],
        ];
    }
}
