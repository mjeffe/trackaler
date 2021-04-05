<div id="container"></div>

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
