<div id="container"></div>

@php
// format data needed for this chart
$minDate = $tracker->metrics->first()->measured_on->toFormattedDateString();
$maxDate = $tracker->metrics->last()->measured_on->toFormattedDateString();

// Values are stored as strings. If we convert here in php, it
// would use the server's locale. Instead we insert the data
// as a json object and let the browser convert them into
// numbers so the user's locale is used. 
$seriesData = $tracker->metrics->map(function ($item) {
    return [
        'metric_id' => $item->id,
        'tracker_id' => $item->tracker_id,
        // get datetime in milliseconds (for javascript)
        'x' => $item->measured_on->valueOf(),
        //'y' => (double)$item->value,  // uses server's locale
        'y' => $item->value,
    ];
});

$goalSeriesData = [];
if ($tracker->goal_value) {
    //
    // If we have no goal end date, then simply show a horizontal line at the goal value
    // starting at the date of the first metric and ending at the date of the last metric.
    //
    // If we have a goal end date, then start the goal series at the value and date of
    // the first metric, and end it at the goal date and value.
    //
    $start = [
        'x' => $tracker->metrics->first()->measured_on->valueOf(),
        'y' => $tracker->goal_timestamp
                    ? $tracker->metrics->first()->value
                    : $tracker->goal_value
    ];
    $end = [
        'x' => $tracker->goal_timestamp
                    ? $tracker->goal_timestamp->valueOf()
                    : $tracker->metrics->last()->measured_on->valueOf(),
        'y' => $tracker->goal_value
    ];
    $goalSeriesData = [$start,  $end];
}
@endphp

<script>
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
            format: '{value} {{ $tracker->display_units }}'
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
