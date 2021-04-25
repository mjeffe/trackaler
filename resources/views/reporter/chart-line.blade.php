<div class="inline-flex items-center">
    <x-page-title>
        {{ Str::title($tracker->metric) }} Tracker
    </x-page-title>
    <x-help>
        <p class="pb-2">
            This is a graph of all data points you have recoreded for this tracker, and your goal
            if you set one.
        </p>
        <p class="pb-2">
            You can toggle each line on or off by clicking on the name in the legend
            at the bottom of the graph.
        </p>
        <p class="pb-2">
            You can zoom in on a section, by clicking and dragging, or use a two
            finger pinch gesture on mobile devices. Just click the
            <span class="font-semibold">Reset Zoom</span> button to return to the full view.
        </p>
        <p class="pb-2">
            Click on a data point node to edit. You can also return to the home
            page and click the "data" button to edit data points.
        </p>
    </x-help>
</div>

<x-card width="full">
    <div class="mt-3">
        <div id="container"></div>
    </div>
</x-card>

<script>
{{--
    // Here, we insert the php built data as json objects.  This allows us to
    // convert data (time, floats, etc) using the browser's locale.
--}}
const seriesRawData = {!! json_encode($seriesData) !!}
const goalSeriesRawData = {!! json_encode($goalSeriesData) !!}

const seriesData = seriesRawData.map((row) => {
    return {
        'metric_id': row.metric_id,
        'tracker_id': row.tracker_id,
        'x': row.x,
        'y': parseFloat(row.y),
    };
}); 
const goalSeriesData = goalSeriesRawData.map((row) => {
    return {
        'tracker_id': row.tracker_id,
        'x': row.x,
        'y': parseFloat(row.y),
    };
});
 
Highcharts.chart('container', {
    chart: {
        type: 'line',
        zoomType: 'x',
    },

    //colors: ['blue', 'red'],

    title: {
        text: '{{ Str::title($tracker->metric) }} over time'
    },

    subtitle: {
        text: 'from {{ $minDate }} to {{ $maxDate }}'
    },
    
    yAxis: {
        title: {
            text: '{{ Str::title($tracker->metric) }}'
        },
        labels: {
            format: '{value} {{ $tracker->units }}'
        },
    },

    xAxis: {
        // force one on label per day
        //tickInterval: 24 * 3600 * 1000, // 1 day in milliseconds
        type: 'datetime',
        dateTimeLabelFormats: {
            day: '%e %b',
            week: '%e %b',
        },
        /*
        title: {
            text: 'Date'
        },
        */
        accessibility: {
            rangeDescription: 'Range: {{ $minDate }} to {{ $maxDate }}'
        }
    },

    /*
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
     */

    plotOptions: {
        series: {
            cursor: 'pointer',
            point: {
                events: {
                    click: function (e) {
                        window.location.href = '{{ url('tracker/') }}'
                            + '/' + e.point.tracker_id
                            + '/metric/' + e.point.metric_id
                            + '/edit';
                    }
                }
            },
        },
        line: {
            /*
            dataLabels: {
                enabled: true
            },
             */
            // enableMouseTracking: false
            marker: {
                enabled: false,
                //radius: 3,
            },
        }
    },

    series: [{
        type: 'line',
        name: '{{ $tracker->metric }}',
        data: seriesData,
    },
    @if (!empty($goalSeriesData))
    {
        type: 'line',
        name: 'goal',
        color: 'red',
        data: goalSeriesData,
    }
    @endif
    ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>
