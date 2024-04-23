<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HeaterRecord;

class Heater extends Component
{
    //public variables that can be accessed from the view.
    public $currentHeaterStatus;
    public $showCurrentStatus;
    public $heaterRecords;

    public bool $field;

    public function getUpdatedHistoricalData(){
        //get the last 50 records from the HeaterStatus model. This will be temporarily stored and used in the next step.
        $allHeaterRecords = HeaterRecord::orderBy('created_at', 'asc')->take(50)->get();

        //we need to make a multidimensional array that will store each instance of where the heater was on.
        //we need to analyse the data in the $allHeaterRecords array and using the times where the status was true, and the next time it was false, we can calculate the time the heater was on.
        //each instance of the heater being on should be stored in the $heaterRecords array.
        $heaterRecords = [];
        $heaterRecord = [];
        $isHeaterOn = false;
        $lastHeaterOnTime = null;
        foreach ($allHeaterRecords as $record) {
            if ($record->status == true) {
                //if the heater is already on, we don't need to do anything as we are already tracking the time it was turned on.
                if($isHeaterOn == true){
                    continue;
                }
                $isHeaterOn = true;
                $lastHeaterOnTime = $record->created_at;
            } else {
                if ($isHeaterOn) {
                    $heaterRecord['on'] = $lastHeaterOnTime;
                    $heaterRecord['off'] = $record->created_at;
                    //store the difference in seconds between the two times and ensure this is rounded to a whole number.
                    $heaterRecord['duration'] = round($heaterRecord['on']->diffInSeconds($heaterRecord['off']));
                    //has the heater been on for more than 60 seconds?
                    if($heaterRecord['duration'] > 60){
                        $heaterRecords[] = $heaterRecord;
                    }
                    $heaterRecord = [];
                    $isHeaterOn = false;
                }
            }
        }
        //reverse the array so the most recent records are at the top.
        $heaterRecords = array_reverse($heaterRecords);

        return $heaterRecords;
    }

    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //we are currently setting the first load to a string, we will check if the value is true or false in the view. if it is a string we will say the data is loading.
        if (!isset($this->currentHeaterStatus)) {
            $this->currentHeaterStatus = "unknown";
        }

        //by default we should show the current status
        $this->showCurrentStatus = true;

        //get the updated historical data and store it in the heaterRecords array.
        $this->heaterRecords = $this->getUpdatedHistoricalData();
    }

    public function updateData($newHeaterStatus)
    {
        //update the currentInside value in the live view based on the new data from the pusher event, this method is called from the frontend.
        $this->currentHeaterStatus = $newHeaterStatus;
    }

    public function toggleCurrent()
    {
        //toggle the showCurrentStatus variable between true and false.
        $this->showCurrentStatus = !$this->showCurrentStatus;
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        //return temperature view with currentInside and currentOutside values.
        return view('livewire.heater')->with([
            'currentHeaterStatus' => $this->currentHeaterStatus,
            'showCurrent' => $this->showCurrentStatus,
            'heaterRecords' => $this->heaterRecords
        ]);
    }
}
