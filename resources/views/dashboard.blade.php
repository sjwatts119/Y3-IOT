<x-app-layout>

    @if(!empty($warning))

        {{-- make a warning component with the warning message --}}
        <x-warning :warning="$warning" class="mb-4" />

    @endif

    {{-- make a container row for the three card components with width 100% --}}
    <div class="flex flex-row w-full justify-center h-60">

        {{-- make a card component with the title "Heater" --}}
        <x-card header="Heater">
            {{-- make a slot for the body of the card --}}
            <x-slot name="body">
                {{-- we need to show the user whether the heating is on or off with an appropriate icon --}}

                {{-- if the heater is on, show a red fa flame icon --}}
                @if ($heaterOn)
                    <div class="flex flex-col items-center text-4xl">
                        <i class="fas fa-fire text-red-500"></i>
                        <p class="text-red-500">On</p>
                    </div>

                {{-- if the heater is off, show a grey fa flame icon --}}
                @else
                    <div class="flex flex-col items-center text-4xl">
                        <i class="fas fa-fire text-gray-500"></i>
                        <p class="text-gray-500">Off</p>
                    </div>
                    
                @endif
            </x-slot>
        </x-card>

        {{-- make a card component with the title "Window" --}}
        <x-card header="Window">
            {{-- make a slot for the body of the card --}}
            <x-slot name="body">
                {{-- we need to show the user whether the window is open or closed with an appropriate icon --}}

                {{-- if the window is open, show a green fa window-open icon --}}
                @if ($windowOpen)
                    <div class="flex flex-col items-center text-4xl">
                        <i class="fa-solid fa-wind text-blue-500"></i>
                        <p class="text-blue-500">Open</p>
                    </div>

                {{-- if the window is closed, show a grey fa window-close icon --}}
                @else
                    <div class="flex flex-col items-center text-4xl">
                        <i class="fas fa-window-close text-gray-500"></i>
                        <p class="text-gray-500">Closed</p>
                    </div>

                @endif
            </x-slot>
        </x-card>

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

    <div class="flex flex-row w-full justify-center h-60">

        {{-- make two cards for inside and outside temperature --}}
        {{-- the inside temperature card will be a livewire component, we need to pass in currentInside --}}

        @livewire('inside-temperature', ['currentInside' => $currentInside])

        {{-- the outside temperature card will be a regular blade component, we need to pass in currentOutside --}}




        <x-card header="Outside Temperature">
            <x-slot name="body">
                {{-- show the outside temperature with a fa thermometer-half icon --}}
                <div class="flex flex-col items-center text-4xl">
                    <i class="fas fa-thermometer-half text-gray-500"></i>
                    <p class="text-gray-500">{{ $currentOutside }}°C</p>
                </div>
            </x-slot>
        </x-card>

        



</x-app-layout>
