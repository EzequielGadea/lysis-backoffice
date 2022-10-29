<?php

namespace App\Http\Livewire\Events;

use Livewire\Component;

class UpdateEventResultForm extends Component
{
    public $result;

    public $selectedResultTypeId;

    public $resultTypes;

    public $markNames;

    public function mount()
    {
        $this->selectedResultTypeId = $this->result->type->id;
    }

    public function render()
    {
        $data = [
            'resultTypes' => $this->resultTypes,
        ];
        if ($this->selectedResultTypeId == 1)
            $data += ['markNames' => $this->markNames];

        return view('livewire.events.update-event-result-form', $data);
    }
}
