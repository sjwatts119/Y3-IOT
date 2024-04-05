<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Temperature;
use Livewire\Attributes\On;

class InsideTemperature extends Component
{
    //the currentInside property is used to store the latest temperature data.
    public function retrieveData()
    {
        //retrieve the newest temperature data from the database.
        return Temperature::latest()->first()->sensorInside;

    }

    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //is currentInside already defined?
        if (!isset($this->currentInside)) {
            //initialize the currentInside value in the live view. This is necessary to populate the first value, before waiting for the first update.
            $this->currentInside = $this->retrieveData();
        }
        //otherwise, do nothing.
    }

    public function updateData($newInside)
    {
        //update the currentInside value in the live view.
        $this->currentInside = $newInside;
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        return view('livewire.inside-temperature')->with('currentInside', $this->currentInside);
    }
}
