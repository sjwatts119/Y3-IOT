<x-app-layout>

    @if(!empty($warning))

        {{-- make a warning component with the warning message --}}
        <x-warning :warning="$warning" class="mb-4" />

    @endif

    {{-- make a container row for the three card components with width 100% --}}
    <div class="flex flex-row w-full justify-center h-60">

        {{-- include the heater livewire component --}}
        <livewire:heater />

        {{-- include the window livewire component --}}
        <livewire:window />

        {{-- make a card component with the title "Air Conditioning" --}}
        <x-card header="Air Conditioning">
            {{-- make a slot for the body of the card --}}
            <x-slot name="body">
                {{-- we need to show the user whether the air conditioning is on or off with an appropriate icon --}}

                {{-- if the air conditioning is on, show a blue fa snowflake icon --}}
                @if ($acOn)
                    <div class="flex flex-col items-center text-4xl">
                        <i class="fas fa-snowflake text-blue-500"></i>
                        <p class="text-blue-500">On</p>
                    </div>

                {{-- if the air conditioning is off, show a grey fa snowflake icon --}}
                @else
                    <div class="flex flex-col items-center text-4xl">
                        <i class="fas fa-snowflake text-gray-500"></i>
                        <p class="text-gray-500">Off</p>
                    </div>

                @endif
            </x-slot>
        </x-card>

    </div>

    {{-- make a container row for the two card components with width 100% --}}

        {{-- include the temperatures component --}}
        <livewire:temperatures />



</x-app-layout>
