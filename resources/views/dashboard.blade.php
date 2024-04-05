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
        <livewire:air-conditioning />

    </div>

    {{-- make a container row for the two card components with width 100% --}}

        {{-- include the temperatures component --}}
        <livewire:temperatures />



</x-app-layout>
