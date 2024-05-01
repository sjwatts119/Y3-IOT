<x-app-layout>
    @if(!empty($warning))

        {{-- make a warning component with the warning message --}}
        <x-warning :warning="$warning" class="mb-4" />

    @endif

    <livewire:notifications />

    {{-- make a container row for the three card components with width 100% --}}
    <div class="flex flex-wrap w-full justify-center min-h-60">

        {{-- include the heater livewire component --}}
        <livewire:heater />

        {{-- include the window livewire component --}}
        <livewire:window />

        {{-- make a card component with the title "Air Conditioning" --}}
        <livewire:air-conditioning />

    </div>

    {{--80% width divider line for the page--}}
    <div class="w-10/12 mx-auto border-b-2 border-gray-500 my-5"></div>

    {{-- include the temperatures component --}}
    <livewire:temperatures />

    {{--80% width divider line for the page--}}
    <div class="w-10/12 mx-auto border-b-2 border-gray-500 my-5"></div>

    {{-- include the charts component with a width of 90% --}}
    <livewire:charts />

    {{-- include the lights component --}}

</x-app-layout>
