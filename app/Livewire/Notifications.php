<?php

namespace App\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    public $status;

    public function mount(){
        //set status to 0 as no notifications are present.
        $this->status = 0;
    }

    public function updateData($newStatus){
        $this->status = $newStatus;   
    }

    public function render()
    {
        return view('livewire.notifications')->with([
            'status' => $this->status
        ]);
    }
}
