<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'playerVisitorId' => 'exclude_unless:isIndividual,1|required|numeric|exists:players,id',
            'playerLocalId' => 'exclude_unless:isIndividual,1|required|numeric|exists:players,id',
            'teamLocalId' => 'exclude_if:isIndividual,1|required|numeric|exists:teams,id',
            'teamVisitorId' => 'exclude_if:isIndividual,1|required|numeric|exists:teams,id',
            'resultTypeId' => 'required|numeric|exists:result_types,id',
            'setAmount' => 'nullable|numeric|gte:1',
            'markNameId' => 'nullable|numeric|exists:mark_names,id'
        ];
    }
}
