<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Temperature;
use Livewire\Attributes\On;

class Temperatures extends Component
{
    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //is currentInside already defined?
        if (!isset($this->currentInside)) {
            //initialize the currentInside value in the live view. This is necessary to populate the first value, before waiting for the first update.
            $this->currentInside = Temperature::latest()->first()->sensorInside;
        }
        if(!isset($this->currentOutside)) {
            $this->currentOutside = Temperature::latest()->first()->sensorOutside;
        }
    }

    public function updateData($newInside, $newOutside)
    {
        //update the currentInside value in the live view based on the new data from the pusher event, this method is called from the frontend.
        $this->currentInside = $newInside;
        $this->currentOutside = $newOutside;
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        //return temperature view with currentInside and currentOutside values.
        return view('livewire.temperatures')->with([
            'currentInside' => $this->currentInside,
            'currentOutside' => $this->currentOutside
        ]);
    }
}
