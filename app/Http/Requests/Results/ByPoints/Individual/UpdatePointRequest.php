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
            'minute' => [
                'required',
                'integer',
                'min:0',
                'max:999',
                Rule::unique($this->route('point')->getTable())->where(function ($query) {
                    $query->where('by_point_id', $this->route('point')->by_point_id);
                })->ignore($this->route('point'), 'id'),
                Rule::unique($this->route('point')->getTable())->where(function ($query) {
                    $query->where('event_id', $this->route('point')->event_id);
                })->ignore($this->route('point'), 'id'),
            ],
        ];
    }

    public function messages()
    {
        return [
            'minute.unique' => 'The same player, or another player, has already scored at minute ' . $this->minute . '.'
        ];
    }
}
