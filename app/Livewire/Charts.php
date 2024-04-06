<?php

namespace App\Livewire;

use Livewire\Component;

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
        //make a test array of twenty random numbers between 0 and 100.
        for ($i = 0; $i < 20; $i++) {
            $this->chartDataInside[] = rand(0, 100);
        }

        //make a test array of twenty random numbers between 0 and 100.
        for ($i = 0; $i < 20; $i++) {
            $this->chartDataOutside[] = rand(0, 100);
        }

        //make a test array of timestamps for the x-axis labels.
        $this->chartLabels = [
            '12:00:00', '12:00:01', '12:00:02', '12:00:03', '12:00:04', '12:00:05', '12:00:06', '12:00:07', '12:00:08', '12:00:09',
            '12:00:10', '12:00:11', '12:00:12', '12:00:13', '12:00:14', '12:00:15', '12:00:16', '12:00:17', '12:00:18', '12:00:19',
        ];
    }

    //the render function is called every time the component is updated, to render the view.
    public function render()
    {
        return view('livewire.charts')->with([
            'chartDataInside' => $this->chartDataInside,
            'chartDataOutside' => $this->chartDataOutside,
            'chartLabels' => $this->chartLabels
        ]);
    }
}
