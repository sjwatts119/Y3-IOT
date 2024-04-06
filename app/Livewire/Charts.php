<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\RequestData;
use App\Models\Temperature;

class Charts extends Component
{
    //we are going to make a multidimensional array for the chart data. it is going to start with an empty array, and be filled with data from the pusher event.
    //it should only have a maximum of 100 data points, so we will remove the first data point when the array reaches 100.
    public $chartDataInside = [];
    public $chartDataOutside = [];
    public $chartLabels = [];

    //the mount function is called when the component is initialized for the first time.
    public function mount()
    {
        //loop through the last 100 temperature records and add them to the chart data array.
        $temperatures = Temperature::orderBy('created_at', 'desc')->limit(100)->get();

        foreach ($temperatures as $temperature) {
            $this->chartDataInside[] = $temperature->sensorInside;
            $this->chartDataOutside[] = $temperature->sensorOutside;
            $this->chartLabels[] = $temperature->created_at->format('H:i:s');
        }
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        //we should dispatch an event to request the initial data from our pusher channel.
        RequestData::dispatch();

        //when the component is rendered, we will have an event listener that listens for the returned data from our Pi, it will then update the chart data with the new data.

        return view('livewire.charts')->with([
            'chartDataInside' => $this->chartDataInside,
            'chartDataOutside' => $this->chartDataOutside,
            'chartLabels' => $this->chartLabels
        ]);
    }
}
