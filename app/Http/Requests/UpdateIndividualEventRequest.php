<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIndividualEventRequest extends FormRequest
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
            'eventId' => 'required|numeric|exists:events,id',
            'startDate' => 'required|date',
            'venueId' => 'required|numeric|exists:venues,id',
            'leagueId' => 'exclude_if:leagueId,NULL|numeric|exists:leagues,id',
            'playerVisitorId' => 'exclude_unless:isIndiviual,true|required|numeric|exists:players,id',
            'playerLocalId' => 'exclude_unless:isIndiviual,true|required|numeric|exists:players,id'
        ];
    }
}
