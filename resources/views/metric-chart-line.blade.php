<div id="container"></div>

@php
// format data needed for this chart
$minDate = $data->min('measured_on')->toFormattedDateString();
$maxDate = $data->max('measured_on')->toFormattedDateString();

// Values are stored as strings. If we convert here in php, it
// would use the server's locale. Instead we insert the data
// as a json object and let the browser convert them into
// numbers so the user's locale is used. 
$seriesData = $data->map(function ($item) {
    return [
        // get datetime in milliseconds (for javascript)
        'x' => $item->measured_on->valueOf(),
        //'y' => (double)$item->value,  // uses server's locale
        'y' => $item->value,
    ];
});
@endphp

<script>
const seriesRawData = {!! json_encode($seriesData) !!}
const seriesData = seriesRawData.map((row) => {
    return {'x': row.x, 'y': parseFloat(row.y)};
}); 
 
Highcharts.chart('container', {
    chart: {
        type: 'line',
        zoomType: 'x',
    },

    //colors: ['blue', 'red'],

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
        name: '{{ $metric }}',
        data: seriesData,
    },
    /*
    {
        type: 'line',
        name: 'goal',
        color: 'red',
        data: [{
            x: 1609653600000, y: 170
        },{
            x: 1633237200000, y: 120
        }]
    }
    */
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
