@section('custom-css')
@assets
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.umd.js"></script>
@endassets
@endsection

{{-- 100% width container for the chart --}}
<div class="flex flex-row w-screen justify-center">
    <x-card header="Temperature Chart" class="w-11/12">
        <x-slot name="body">
            <div class="chart-container" class="relative" style="height:200px;">
                <canvas id="temperatureChart"></canvas>
            </div>
        </x-slot>
    </x-card>
</div>


@script
<script>
    //make a new chart object to track the change of temperature values over time
    ctx = document.getElementById('temperatureChart').getContext('2d');
    temperatureChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Inside Temperature',
                data: @json($chartDataInside),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Outside Temperature',
                data: @json($chartDataOutside),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
        }
    });

    //listen for the event listener "update" event
    window.addEventListener('realtime-data', event => {

        /*NOTE: I would really like to do this by re-rendering the chart using a livewire method, but chart.js does not want to play nice with livewire so I have to do it this way*/

        //append the data to the chart, if the chart has more than 100 data points, remove the first data point
        temperatureChart.data.labels.push(new Date().toLocaleTimeString());
        temperatureChart.data.datasets[0].data.push(event.detail.payload.currentInside);
        temperatureChart.data.datasets[1].data.push(event.detail.payload.currentOutside);

        if (temperatureChart.data.labels.length > 100) {
            temperatureChart.data.labels.shift();
            temperatureChart.data.datasets[0].data.shift();
            temperatureChart.data.datasets[1].data.shift();
        }

        //update the chart on the client side
        temperatureChart.update();
    });

</script>
@endscript

