<?php

namespace App\Livewire;

use Livewire\Component;

class Heater extends Component
{
    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //we are currently setting the first load to a string, we will check if the value is true or false in the view. if it is a string we will say the data is loading.
        if (!isset($this->currentHeaterStatus)) {
            $this->currentHeaterStatus = "false";
        }
    }

    public function updateData($newHeaterStatus)
    {
        //update the currentInside value in the live view based on the new data from the pusher event, this method is called from the frontend.
        $this->currentHeaterStatus = $newHeaterStatus;
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        //return temperature view with currentInside and currentOutside values.
        return view('livewire.heater')->with([
            'currentHeaterStatus' => $this->currentHeaterStatus
        ]);
    }
}
