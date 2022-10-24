<?php

namespace App\Http\Requests\EventController;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'eventId' => 'required|numeric|exists:events,id',
            'startDate' => 'required|date',
            'venueId' => 'required|numeric|exists:venues,id',
            'isIndividual' => 'required|boolean',
            'leagueId' => 'exclude_if:leagueId,NULL|numeric|exists:leagues,id',
            'playerVisitorId' => 'exclude_unless:isIndiviual,true|required|numeric|exists:players,id',
            'playerLocalId' => 'exclude_unless:isIndiviual,true|required|numeric|exists:players,id',
            'teamLocalId' => 'exclude_if:isIndividual,true|required|numeric|exists:teams,id',
            'teamVisitorId' => 'exclude_if:isIndividual,true|required|numeric|exists:teams,id'
        ];
    }
}
