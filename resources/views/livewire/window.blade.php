<x-card header="Window">
        <x-slot name="buttons">
        {{-- we should have two buttons. These will toggle the card from showing the current status to the chart of historical data --}}
        <div class="flex flex-row justify-between">
            {{-- make a button with the text "Current Status" --}}
            <button wire:click="showCurrent(true)" class="bg-gray-200 text-gray-700 px-2 rounded-md" title="View Current Status"><i class="fa-solid fa-repeat"></i></button>

            {{-- make a button with the text "Historical Data" --}}
            <button wire:click="showCurrent(false)" class="bg-gray-200 text-gray-700 px-2 rounded-md" title="View Historic Statuses"><i class="fa-solid fa-clock-rotate-left"></i></button>
        </div>
    </x-slot>
    {{-- make a slot for the body of the card --}}
    <x-slot name="body">
        {{-- if the showCurrentStatus property is true, show the current status --}}
        @if($showCurrent)
            {{-- we need to show the user whether the heating is on or off with an appropriate icon --}}

            <div class="p-12 min-h-48">

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
            </div>

            @else
            <div class="flex flex-col items-center text-sm">
                {{-- if the showCurrentStatus property is false, show the historical data using chartjs --}}
                @foreach($windowRecords as $windowRecord)

                {{--we need to make a pretty display with internal overflow scrolling downwards using tailwind classes--}}
                <div class="flex flex-col items-center text-sm">
                    @if($windowRecord['duration'] > 3600)
                    {{--we need to show the day, month and the time of the Window being turned on, and the duration it was on for--}}
                        <p class="text-red-600">{{ $windowRecord['open']->format('d/m H:i') }} for {{ round($windowRecord['duration'] / 3600, 0) }} hours</p>
                    @else
                        <p class="text-green text-green-600">{{ $windowRecord['open']->format('d/m H:i') }} for {{ round($windowRecord['duration'] / 60, 0) }} minutes</p>
                    @endif
                </div>
                @endforeach
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
