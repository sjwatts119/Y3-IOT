<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemperatureController extends Controller
{
    public function index()
    {

        //Create array to use when passing data to the view
        //THIS WILL EVENTUALLY BE COLLECTED BY THE MODEL AND PASSED TO THE VIEW
        $data = [
            'heaterOn' => true,
            'windowOpen' => true,
            'acOn' => false,
        ];

        // We should check some combinations of the data and set a warning message if they aren't deemed energy efficient. If there is more than one warning condition, we should have a fallback saying that the user is wasting energy.

        //This is fairly rudimentary logic, but it will suffice for now. We will improve this in the next task.
        // If the heater is on and the window is open, we should set a warning message
        if ($data['heaterOn'] && $data['windowOpen']) {
            $data['warning'] = 'You are wasting energy! The heater is on and the window is open.';
        }
        // If the air conditioner is on and the window is open, we should set a warning message
        if ($data['acOn'] && $data['windowOpen']) {
            $data['warning'] = 'You are wasting energy! The air conditioner is on and the window is open.';
        }

        // If the air conditioner is on and the heater is on, we should set a warning message
        if ($data['acOn'] && $data['heaterOn']) {
            $data['warning'] = 'You are wasting energy! The air conditioner is on and the heater is on.';
        }

        // We need to return the view file and pass in parameter heaterOn as a boolean value
        return view('dashboard', $data);
    }
}
