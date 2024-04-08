<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AcRecord;

class AirConditioning extends Component
{
    //public variables to store the currentInside and currentOutside values.
    public $currentACStatus;
    public $showCurrentStatus;
    public $acRecords;
    
    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //we are currently setting the first load to a string, we will check if the value is true or false in the view. if it is a string we will say the data is loading.
        if (!isset($this->currentACStatus)) {
            $this->currentACStatus = "unknown";
        }

        //by default we should show the current status
        $this->showCurrentStatus = true;

        //we should retrieve the last 5 records using the HeaterRecord model. we will order the records by the created_at column in descending order.
        $this->acRecords = AcRecord::orderBy('created_at', 'desc')->take(5)->get();
    }

    public function updateData($newACStatus)
    {
        //update the currentInside value in the live view based on the new data from the pusher event, this method is called from the frontend.
        $this->currentACStatus = $newACStatus;

        //we should retrieve the last 5 records using the HeaterRecord model. we will order the records by the created_at column in descending order.
        $this->acRecords = AcRecord::orderBy('created_at', 'desc')->take(5)->get();
    }

    public function showCurrent($isCurrent)
    {
        //update the currentInside value in the live view based on the new data from the pusher event, this method is called from the frontend.
        $this->showCurrentStatus = $isCurrent;
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        //return temperature view with currentInside and currentOutside values.
        return view('livewire.air-conditioning')->with([
            'currentACStatus' => $this->currentACStatus,
            'showCurrent' => $this->showCurrentStatus,
            'acRecords' => $this->acRecords
        ]);
    }
}
