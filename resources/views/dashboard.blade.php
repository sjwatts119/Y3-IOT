<x-app-layout>
    @if(!empty($warning))

        {{-- make a warning component with the warning message --}}
        <x-warning :warning="$warning" class="mb-4" />

    @endif
    {{-- keep the page within a 75% width container --}}
    <div class="w-3/4 m-auto">

        {{-- make a container row for the three card components with width 100% --}}
        <div class="flex flex-row w-full justify-center h-60">

            {{-- include the heater livewire component --}}
            <livewire:heater />

            {{-- include the window livewire component --}}
            <livewire:window />

            {{-- make a card component with the title "Air Conditioning" --}}
            <livewire:air-conditioning />

        </div>
    </div>

    {{-- include the temperatures component --}}
    <livewire:temperatures />

    {{-- include the charts component --}}
    <livewire:charts />

</x-app-layout>
