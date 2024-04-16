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

            <div class="p-8">

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
                    <p>{{ $windowRecord->created_at->format('H:i:s') }} - {{ $windowRecord->status ? 'Open' : 'Closed' }}</p>
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
