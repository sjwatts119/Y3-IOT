<x-card header="Air-Con">
    <x-slot name="buttons">
        {{-- we should have two buttons. These will toggle the card from showing the current status to the chart of historical data --}}
        <div class="flex flex-row justify-between">
            {{-- make a button with the text "Historical Data" --}}
            <button wire:click="toggleCurrent()" class="bg-gray-200 text-gray-700 px-2 rounded-md" title="View Historic Statuses"><i class="fa-solid fa-clock-rotate-left @if(!$showCurrent)text-blue-700 @endif"></i></button>
        </div>
    </x-slot>
    {{-- make a slot for the body of the card --}}
    <x-slot name="body">
        <div class="h-48">
            {{-- if the showCurrentStatus property is true, show the current status --}}
            @if($showCurrent)
                <div class="p-12">
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
                        {{--we need to loop through the ACRecords array and output the data in a table row--}}
                        {{--we have access to every instance the AC turned on, and how long it was turned on for--}}

                        @foreach($acRecords as $acRecord)
                            <tr class="text-center">
                                {{--show a blue snowflake icon identical to the one used in the current status display--}}
                                <td class="border px-4 py-2">
                                    <i class="fas fa-snowflake text-blue-500"></i>
                                </td>
                                <td class="border px-4 py-2">{{ $acRecord['on']->format('d/m H:i') }}</td>
                                {{--if the duration is less than 60 minutes, show the duration in minutes--}}
                                {{--if the duration is more than 60 minutes, show the duration in hours and minutes--}}
                                @if($acRecord['duration'] > 3600)
                                    <td class="border px-4 py-2">{{ round($acRecord['duration'] / 3600, 0) }} hours</td>
                                {{--if the duration is less than 3600 seconds, we should show the duration in minutes--}}
                                @else
                                    <td class="border px-4 py-2">{{ round($acRecord['duration'] / 60, 0) }} minutes</td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @endif
        </div>
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
