{{--STATUS MEANINGS
//0: No Action Required, Temp Goal Being Met, Heating: OFF, Window: CLOSED, AC: OFF
//1: Pipe Protection if Temp below 4c, Heating: ON, Window: CLOSED, AC: OFF.
//2: Heating until Goal Temp, Heating: ON, Window: CLOSED, AC: OFF.
//3: Cooling until Goal Temp, Heating: OFF, Window: CLOSED, AC: ON
//4  Opening Windows, Passively Cooling until Temp Goal, Heating: OFF, Window: OPEN, AC: OFF,
//5: 
//6:--}}

<div>

    {{--check there is a status and make sure it doesn't == 0 as this status doesn't require a popup.--}}
    @if($status !== 0)
    <div class="absolute w-full top-16 right-0 bg-red-500 opacity-90 hover:opacity-100 text-white shadow-lg transition ease-in-out duration-150 h-8 px-6">
        <div class="flex justify-between items-center w-full h-full px-12">
            {{--show the message that was passed in from the livewire component--}}
            @switch($status)
                @case(1)
                    <p>WARNING: Heating is on to protect pipes from freezing</p>
                    @break
                @case(2)
                    <p>Heating is on to reach the goal temperature</p>
                    @break
                @case(3)
                    <p>AC is on to reach the goal temperature</p>
                    @break
                @case(4)
                    <p>Windows are open to cool the house</p>
                    @break
                @case(5)
                    <p>System is not running, all utilities are off</p>
                    @break
            @endswitch
        </div>
    </div>

    @endif
</div>

@script
<script>

    //listen for the event from echo.js and refresh livewire component
    window.addEventListener('realtime-data', event => {
        //update the status of the notification
        $wire.updateData(event.detail.payload.status);
    });

</script>
@endscript
