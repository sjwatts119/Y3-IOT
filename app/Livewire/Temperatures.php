<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Temperature;
use Livewire\Attributes\On;

class Temperatures extends Component
{
    //define the public variables that will be used in the blade view.
    public $currentInside;
    public $currentGoal;
    public $currentOutside;
    public $insideStale;
    public $goalStale;
    public $outsideStale;

    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //is currentInside already defined?
        if (!isset($this->currentInside)) {
            //because we are pulling old data, we need to set this to use in the blade to show the user the data is loading
            $this->insideStale = true;
            $this->currentInside = 0;
        }
        if(!isset($this->currentGoal)) {
            $this->goalStale = true;
            $this->currentGoal = 0;
        }
        if(!isset($this->currentOutside)) {
            $this->outsideStale = true;
            $this->currentOutside = 0;
        }
    }

    public function updateData($newInside, $newGoal, $newOutside)
    {
        //update the currentInside value in the live view based on the new data from the pusher event, this method is called from the frontend.
        $this->currentInside = $newInside;
        $this->currentGoal = $newGoal;
        $this->currentOutside = $newOutside;

        //set the stale values to false, because we have new data.
        $this->insideStale = false;
        $this->goalStale = false;
        $this->outsideStale = false;
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        //return temperature view with currentInside and currentOutside values.
        return view('livewire.temperatures')->with([
            'currentInside' => $this->currentInside,
            'currentGoal' => $this->currentGoal,
            'currentOutside' => $this->currentOutside,
            'insideStale' => $this->insideStale,
            'goalStale' => $this->goalStale,
            'outsideStale' => $this->outsideStale
        ]);
    }
}
