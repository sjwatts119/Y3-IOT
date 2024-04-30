@section('custom-css')
@assets
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.umd.js"></script>
@endassets
@endsection

{{-- chart should be within a flex container that takes up 90% width and is in the middle of the page--}}
<div class="flex flex-col items-center w-full mx-auto px-5">
    <x-card header="Temperature Chart" class="w-full">
        <x-slot name="body">
            <div class="chart-container" class="relative" style="height:250px;">
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

    var newData;

    function updateChart(newData) {
        //append the data to the chart, if the chart has more than 100 data points, remove the first data point
        temperatureChart.data.labels.push(new Date().toLocaleTimeString());
        temperatureChart.data.datasets[0].data.push(newData.currentInside);
        temperatureChart.data.datasets[1].data.push(newData.currentOutside);

        if (temperatureChart.data.labels.length >= 100) {
            temperatureChart.data.labels.shift();
            temperatureChart.data.datasets[0].data.shift();
            temperatureChart.data.datasets[1].data.shift();
        }

        //update the chart on the client side
        temperatureChart.update();
    }

    //listen for the event listener "update" event
    window.addEventListener('realtime-data', event => {
        /*NOTE: I would really like to do this by re-rendering the chart using a livewire method, but chart.js does not want to play nice with livewire so I have to do it this way*/

        //set newData to the new data so we can access it when the chart is updated
        newData = event.detail.payload;
    });

    //every 10 seconds, update the chart with the new data
    setInterval(() => {
        if (newData) {
            updateChart(newData);
        }
    }, 10000);

</script>
@endscript

