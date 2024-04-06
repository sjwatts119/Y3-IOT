<div class="flex flex-row w-full justify-center h-60">
    <x-card header="Inside Temperature">
        <x-slot name="body">
            {{-- if the inside temperature is stale data, we should instead say waiting for sensor --}}
            @if($insideStale)
            <div class="flex flex-col items-center text-2xl">
                <i class="fas fa-spinner fa-spin text-gray-500"></i>
                <p class="text-gray-500 mt-5">Contacting Sensor...</p>
            </div>
            @else
            {{-- show the inside temperature with a fa thermometer-half icon --}}
            <div class="flex flex-col items-center text-4xl">

                <i class="fas fa-thermometer-half text-gray-500"></i>
                {{--output the most recent temperature reading from the sensor. this is being passed in as $currentInside --}}
                <p class="text-gray-500">{{$currentInside}}°C</p>
            </div>
            @endif
        </x-slot>
    </x-card>

    <x-card header="Outside Temperature">
        <x-slot name="body">
            {{-- if the outside temperature is stale data, we should instead say waiting for sensor --}}
            @if($outsideStale)
            <div class="flex flex-col items-center text-2xl">
                <i class="fas fa-spinner fa-spin text-gray-500"></i>
                <p class="text-gray-500 mt-5">Contacting Sensor...</p>
            </div>
            @else
            {{-- show the outside temperature with a fa thermometer-half icon --}}
            <div class="flex flex-col items-center text-4xl">
                <i class="fas fa-thermometer-half text-gray-500"></i>
                {{--output the most recent temperature reading from the sensor. this is being passed in as $currentOutside --}}
                <p class="text-gray-500">{{$currentOutside}}°C</p>
            </div>
            @endif
        </x-slot>
    </x-card>
</div>

@script
<script>
    //listen for the event from echo.js and refresh livewire component
    window.addEventListener('realtime-data', event => {
        $wire.updateData(event.detail.payload.currentInside, event.detail.payload.currentOutside);
    });

</script>
@endscript
