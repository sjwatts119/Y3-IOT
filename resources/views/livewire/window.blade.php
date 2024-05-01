<x-card header="Window">
        <x-slot name="buttons">
        {{-- we should have two buttons. These will toggle the card from showing the current status to the chart of historical data --}}
        <div class="flex flex-row justify-between">
             {{-- make a button with the text "Historical Data" --}}
             <button wire:click="toggleCurrent()" class="bg-gray-200 px-2 rounded-md" title="View Historic Statuses"><i class="fa-solid fa-clock-rotate-left @if(!$showCurrent)text-blue-700 hover:text-blue-400 @else text-gray-700 hover:text-gray-400 @endif"></i></button>
        </div>
    </x-slot>
    {{-- make a slot for the body of the card --}}
    <x-slot name="body">
        <div class="h-48">
            {{-- if the showCurrentStatus property is true, show the current status --}}
            @if($showCurrent)
                {{-- we need to show the user whether the heating is on or off with an appropriate icon --}}

                <div class="p-12">

                    {{-- if the Window is open, show a blue wind icon --}}
                    @if ($currentWindowStatus === true)
                        <div class="flex flex-col items-center text-4xl">
                            <i class="fa-solid fa-wind text-blue-500"></i>
                            <p class="text-blue-500">Open</p>
                        </div>

                    {{-- if the Window is closed, show a grey window closed icon--}}
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
                <div class="overflow-y-auto max-h-full">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Time</th>
                                <th class="px-4 py-2">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--we need to loop through the windowRecords array and output the data in a table row--}}
                            {{--we have access to every instance the window was opened, and how long it was opened for--}}

                            @foreach($windowRecords as $windowRecord)
                                <tr class="text-center">
                                    {{--show a red fa flame icon identical to the one used in the current status display--}}
                                    <td class="border px-4 py-2">
                                        <i class="fa-solid fa-wind text-blue-500"></i>
                                    </td>
                                    {{--show the time the window was opened--}}
                                    <td class="border px-4 py-2">{{ $windowRecord['open']->format('d/m H:i') }}</td>
                                    {{--show the duration the window was opened for--}}
                                    @if($windowRecord['duration'] > 3600)
                                        <td class="border px-4 py-2">{{ round($windowRecord['duration'] / 3600, 0) }} hour(s)</td>
                                    @else
                                        <td class="border px-4 py-2">{{ round($windowRecord['duration'] / 60, 0) }} minute(s)</td>
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
        $wire.updateData(event.detail.payload.currentWindowStatus);
    });

</script>
@endscript
