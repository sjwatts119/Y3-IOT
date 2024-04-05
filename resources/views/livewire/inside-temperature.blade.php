<x-card header="Inside Temperature">
    <x-slot name="body">
        {{-- show the inside temperature with a fa thermometer-half icon --}}
        <div class="flex flex-col items-center text-4xl">
            <i class="fas fa-thermometer-half text-gray-500"></i>
            {{--output the most recent temperature reading from the sensor. this is being passed in as $currentInside --}}
            <p class="text-gray-500">{{$currentInside}}°C</p>
        </div>
    </x-slot>
</x-card>

@script
<script>
    // catch the even from echo.js and refresh live wire component
    window.addEventListener('realtime-data', event => {
        console.log(event.detail.payload.currentInside);
        $wire.updateData(event.detail.payload.currentInside);
    });

</script>
@endscript


    
