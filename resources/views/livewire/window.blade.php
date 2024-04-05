<x-card header="Window">
    {{-- make a slot for the body of the card --}}
    <x-slot name="body">
        {{-- we need to show the user whether the heating is on or off with an appropriate icon --}}

        {{-- if the Window is on, show a red fa flame icon --}}
        @if ($currentWindowStatus === true)
            <div class="flex flex-col items-center text-4xl">
                <i class="fa-solid fa-wind text-blue-500"></i>
                <p class="text-blue-500">Open</p>
            </div>

        {{-- if the Window is off, show a grey fa flame icon --}}
        @elseif ($currentWindowStatus === false)
            <div class="flex flex-col items-center text-4xl">
                <i class="fas fa-window-close text-gray-500"></i>
                <p class="text-gray-500">Closed</p>
            </div>
        @else
            {{-- if Window status is not known, show a loading icon whilst we wait for the pusher event --}}
            <div class="flex flex-col items-center text-2xl">
                <i class="fas fa-spinner fa-spin text-gray-500"></i>
                <p class="text-gray-500 mt-5">Contacting Sensor...</p>
            </div>
        @endif
    </x-slot>
</x-card>

@script
<script>
    //listen for the event from echo.js and refresh livewire component
    window.addEventListener('realtime-data', event => {
        $wire.updateData(event.detail.payload.currentWindowStatus);
    });

</script>
@endscript