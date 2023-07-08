<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Connection extends Component
{
    public $connections;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($connections)
    {
        $this->connections = $connections;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.connection');
    }
}
