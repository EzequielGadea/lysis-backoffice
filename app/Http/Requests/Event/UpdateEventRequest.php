<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'startDate' => 'required|date_format:"Y-m-d\TH:i"',
            'venueId' => 'required|numeric|exists:venues,id',
            'isIndividual' => 'required|boolean',
            'leagueId' => 'required|numeric|exists:leagues,id',
        ];
    }
}
