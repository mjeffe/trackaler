<div id="container"></div>

@php
// format data needed for this chart
$minDate = $data->min('measured_on')->toFormattedDateString();
$maxDate = $data->max('measured_on')->toFormattedDateString();

$seriesData = $data->map(function ($item) {
    return [
        // get datetime in milliseconds (for javascript)
        'x' => $item->measured_on->valueOf(),
        'y' => intval($item->value),
    ];
});
@endphp

<script>
Highcharts.chart('container', {
    chart: {
        type: 'line',
        zoomType: 'x'
    },

    title: {
        text: '{{ Str::title($metric) }} over time'
    },

    subtitle: {
        text: 'from {{ $minDate }} to {{ $maxDate }}'
    },
    

    yAxis: {
        title: {
            text: '{{ Str::title($metric) }}'
        }
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
        line: {
            dataLabels: {
                enabled: true
            },
            // enableMouseTracking: false
        }
    },

    series: [{
        type: 'line',
        name: '{{ $metric }}',
        data: {!! json_encode($seriesData) !!}
    }],

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
