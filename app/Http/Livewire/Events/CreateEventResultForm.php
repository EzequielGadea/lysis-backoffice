<?php

namespace App\Http\Livewire\Events;

use Livewire\Component;

class CreateEventResultForm extends Component
{
    public $resultTypeId = '';

    public $resultTypes;

    public $markNames;

    public function render()
    {
        $data = [
            'resultTypes' => $this->resultTypes,
        ];
        if ($this->resultTypeId == 1)
            $data += ['markNames' => $this->markNames];

        return view('livewire.events.create-event-result-form', $data);
    }
}
