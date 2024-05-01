<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WindowRecord;

class Window extends Component
{
    public $currentWindowStatus;
    public $showCurrentStatus;
    public $windowRecords;

    public function getUpdatedHistoricalData(){
        //get all records using the WindowRecord model. This will be temporarily stored and used in the next step
        $allWindowRecords = WindowRecord::orderBy('created_at', 'asc')->get();

        //slice to remove records so only the last 100 remain.
        $allWindowRecords = $allWindowRecords->slice(-100);

        //we need to make a multidimensional array that will store each instance of where the window was opened.
        //we need to analyse the data in the $allWindowRecords array and using the times where the status was true, and the next time it was false, we can calculate the time the window was open.
        //each instance of the window being open should be stored in the $windowRecords array.

        $windowRecords = [];
        $windowRecord = [];
        $windowOpen = false;
        $windowOpenTime = null;
        foreach ($allWindowRecords as $record) {
            if ($record->status == true) {
                //if the window is already open, we don't need to do anything as we are already tracking the time it was opened.
                if($windowOpen == true){
                    continue;
                }
                $windowOpen = true;
                $windowOpenTime = $record->created_at;
            } else {
                if ($windowOpen) {
                    $windowRecord['open'] = $windowOpenTime;
                    $windowRecord['closed'] = $record->created_at;
                    //store the difference in seconds between the two times and ensure this is rounded to a whole number.
                    $windowRecord['duration'] = round($windowRecord['open']->diffInSeconds($windowRecord['closed']));
                    //has the window been open for more than 60 seconds?
                    if($windowRecord['duration'] > 60){
                        $windowRecords[] = $windowRecord;
                    }
                    $windowRecord = [];
                    $windowOpen = false;
                }
            }
        }

        //reverse the array so the most recent records are at the top.
        $windowRecords = array_reverse($windowRecords);

        return $windowRecords;
    }

    public function updateData($newWindowStatus)
    {
        //update the currentInside value in the live view based on the new data from the pusher event, this method is called from the frontend.
        $this->currentWindowStatus = $newWindowStatus;

        //FIX we need to be populating this properly again but for testing we are disabling the ability for the pusher event to change the contents of the windowRecords array.
    }

    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //we are currently setting the first load to a string, we will check if the value is true or false in the view. if it is a string we will say the data is loading.
        if (!isset($this->currentWindowStatus)) {
            $this->currentWindowStatus = "unknown";
        }

        //by default we should show the current status
        $this->showCurrentStatus = true;

        //call the getUpdatedHistoricalData function to get the latest data from the database.
        $this->windowRecords = $this->getUpdatedHistoricalData();
    }

    public function toggleCurrent()
    {
        //toggle the showCurrentStatus variable between true and false.
        $this->showCurrentStatus = !$this->showCurrentStatus;
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        //call the getUpdatedHistoricalData function to get the latest data from the database.
        $this->windowRecords = $this->getUpdatedHistoricalData();

        //return temperature view with currentInside and currentOutside values.
        return view('livewire.window')->with([
            'currentWindowStatus' => $this->currentWindowStatus,
            'showCurrent' => $this->showCurrentStatus,
            'windowRecords' => $this->windowRecords
        ]);
    }
}
