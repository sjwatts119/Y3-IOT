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

    public function getUpdatedHistoricalData(){
        //get the last 50 records from the HeaterStatus model. This will be temporarily stored and used in the next step.
        $allACRecords = AcRecord::orderBy('created_at', 'asc')->take(50)->get();

        //we need to make a multidimensional array that will store each instance of where the heater was on.
        //we need to analyse the data in the $allHeaterRecords array and using the times where the status was true, and the next time it was false, we can calculate the time the heater was on.
        //each instance of the heater being on should be stored in the $heaterRecords array.
        $acRecords = [];
        $acRecord = [];
        $isACOn = false;
        $lastACOnTime = null;
        foreach ($allACRecords as $record) {
            if ($record->status == true) {
                //if the heater is already on, we don't need to do anything as we are already tracking the time it was turned on.
                if($isACOn == true){
                    continue;
                }
                $isACOn = true;
                $lastACOnTime = $record->created_at;
            } else {
                if ($isACOn) {
                    $acRecord['on'] = $lastACOnTime;
                    $acRecord['off'] = $record->created_at;
                    //store the difference in seconds between the two times and ensure this is rounded to a whole number.
                    $acRecord['duration'] = round($acRecord['on']->diffInSeconds($acRecord['off']));
                    //has the AC been on for more than 60 seconds?
                    if($acRecord['duration'] > 60){
                        $acRecords[] = $acRecord;
                    }
                    $acRecord = [];
                    $isACOn = false;
                }
            }
        }
        //reverse the array so the most recent records are at the top.
        $acRecords = array_reverse($acRecords);

        return $acRecords;
    }

    public function updateData($newACStatus)
    {
        //update the currentInside value in the live view based on the new data from the pusher event, this method is called from the frontend.
        $this->currentACStatus = $newACStatus;
    }

    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //we are currently setting the first load to a string, we will check if the value is true or false in the view. if it is a string we will say the data is loading.
        if (!isset($this->currentACStatus)) {
            $this->currentACStatus = "unknown";
        }

        //by default we should show the current status
        $this->showCurrentStatus = true;

        //get the updated historical data and store it in the heaterRecords array.
        $this->acRecords = $this->getUpdatedHistoricalData();
    }

    public function toggleCurrent()
    {
        //if the current status is being shown, we should hide it. If it is hidden, we should show it.
        $this->showCurrentStatus = !$this->showCurrentStatus;
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
