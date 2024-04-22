<x-card header="Heater">
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
        <div class="h-48">

            {{-- if the showCurrentStatus property is true, show the current status --}}
            @if($showCurrent)
                <div class="p-12">

                    {{-- we need to show the user whether the heating is on or off with an appropriate icon --}}
                    {{-- if the heater is on, show a red fa flame icon --}}
                    @if ($currentHeaterStatus === true)
                        <div class="flex flex-col items-center text-4xl">
                            <i class="fas fa-fire text-red-500"></i>
                            <p class="text-red-500">On</p>
                        </div>

                    {{-- if the heater is off, show a grey fa flame icon --}}
                    @elseif ($currentHeaterStatus === false)
                        <div class="flex flex-col items-center text-4xl">
                            <i class="fas fa-fire text-gray-500"></i>
                            <p class="text-gray-500">Off</p>
                        </div>
                    @else
                        {{-- if heater status is not known, show a loading icon whilst we wait for the pusher event --}}
                        <div class="flex flex-col items-center text-2xl">
                            <i class="fas fa-spinner fa-spin text-gray-500"></i>
                            <p class="text-gray-500 mt-5">Contacting Sensor...</p>
                        </div>
                    @endif
                </div>
            @else

                {{--WITHOUT using flex classes, we need to show the historical data using a table and have it scrollable if there are many records--}}
                <div class="overflow-y-auto max-h-full">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Time</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--we need to loop through the heaterrecords array and output the data in a table row--}}
                            {{--we have access to every instance the heater turned on, and how long it was turned on for--}}

                            @foreach($heaterRecords as $heaterRecord)
                            {{--align everything in table row to center--}}
                                <tr class="text-center">
                                    {{--show the day, month and the time of the heater being turned on--}}
                                    <td class="border px-4 py-2">{{ $heaterRecord['on']->format('d/m H:i') }}</td>
                                    {{--show a red fa flame icon identical to the one used in the current status display--}}
                                    <td class="border px-4 py-2">
                                        <i class="fas fa-fire text-red-500"></i>
                                    </td>
                                    {{--if the duration is greater than 3600 seconds, we should show the duration in hours--}}
                                    @if($heaterRecord['duration'] > 3600)
                                        <td class="border px-4 py-2">{{ round($heaterRecord['duration'] / 3600, 0) }} hours</td>
                                    @else
                                        {{--if the duration is less than 3600 seconds, we should show the duration in minutes--}}
                                        <td class="border px-4 py-2">{{ round($heaterRecord['duration'] / 60, 0) }} minutes</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </x-slot>
</x-card>

@script
<script>
    //listen for the event from echo.js and refresh livewire component
    window.addEventListener('realtime-data', event => {
        $wire.updateData(event.detail.payload.currentHeaterStatus);
    });

</script>
@endscript
