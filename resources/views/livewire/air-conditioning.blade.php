<x-card header="Air-Con">
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
            <div class="p-12 min-h-48">
                {{-- we need to show the user whether the heating is on or off with an appropriate icon --}}
                {{-- if the AC is on, show a red fa flame icon --}}
                @if ($currentACStatus === true)
                    <div class="flex flex-col items-center text-4xl">
                        <i class="fas fa-snowflake text-blue-500"></i>
                        <p class="text-blue-500">On</p>
                    </div>

                {{-- if the AC is off, show a grey fa flame icon --}}
                @elseif ($currentACStatus === false)
                    <div class="flex flex-col items-center text-4xl">
                        <i class="fas fa-snowflake text-gray-500"></i>
                        <p class="text-gray-500">Off</p>
                    </div>
                @else
                    {{-- if AC status is not known, show a loading icon whilst we wait for the pusher event --}}
                    <div class="flex flex-col items-center text-2xl">
                        <i class="fas fa-spinner fa-spin text-gray-500"></i>
                        <p class="text-gray-500 mt-5">Contacting Sensor...</p>
                    </div>
                @endif
            </div>
        @else
        <div class="flex flex-col items-center text-sm">
            {{-- if the showCurrentStatus property is false, show the historical data using chartjs --}}
            @foreach($acRecords as $acRecord)

            {{--we need to make a pretty display with internal overflow scrolling downwards using tailwind classes--}}
            <div class="flex flex-col items-center text-sm">
                @if($acRecord['duration'] > 3600)
                {{--we need to show the day, month and the time of the AC being turned on, and the duration it was on for--}}
                    <p class="text-red-600">{{ $acRecord['on']->format('d/m H:i') }} for {{ round($acRecord['duration'] / 3600, 0) }} hours</p>
                @else
                    <p class="text-green text-green-600">{{ $acRecord['on']->format('d/m H:i') }} for {{ round($acRecord['duration'] / 60, 0) }} minutes</p>
                @endif
            @endforeach
        </div>
        @endif
    </x-slot>
</x-card>

@script
<script>
    //listen for the event from echo.js and refresh livewire component
    window.addEventListener('realtime-data', event => {
        $wire.updateData(event.detail.payload.currentACStatus);
    });
</script>
@endscript
