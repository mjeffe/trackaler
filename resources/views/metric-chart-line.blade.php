<div id="container"></div>
@php
// extract and format data needed for this chart
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
        type: 'datetime',
            /*
        dateTimeLabelFormats: { // don't display the dummy year
            month: '%e. %b',
            year: '%b'
        },
             */
        title: {
            text: 'Date'
        },
        accessibility: {
            rangeDescription: 'Range: {{ $minDate }} to {{ $maxDate }}'
        }
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
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
