<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConnectionInCommon extends Component
{
    public $connectionInCommon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($connectionInCommon)
    {
        $this->connectionInCommon = $connectionInCommon;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.connection-in-common');
    }
}
