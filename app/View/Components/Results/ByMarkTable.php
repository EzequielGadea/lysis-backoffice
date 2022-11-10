<?php

namespace App\View\Components\Results;

use Illuminate\View\Component;

class ByMarkTable extends Component
{

    public $result;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.results.by-mark-table');
    }
}
