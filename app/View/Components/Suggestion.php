<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Suggestion extends Component
{
    public $suggestions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($suggestions)
    {
        $this->suggestions = $suggestions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {        
        return view('components.suggestion');
    }
}
