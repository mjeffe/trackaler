<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateMetricRequest;

class ReporterController extends Controller {

    public function index() {
        $tracker = new Tracker();

        $trackers = Tracker::where('user_id', Auth::user()->id)
            ->orderBy('metric')
            ->get();

        return view('reporter.index', compact('tracker', 'trackers'));
    }

    public function graph(Request $request, $metric) {
        $tracker = $this->getTrackerWithOrderedMetrics($metric);

        $data['tracker'] = $tracker;

        $data['seriesData'] = $this->formatMetricsAsGraphSeries($tracker->metrics);
        $data['goalSeriesData'] = $this->formatGoalAsGraphSeries($tracker);

        $data['minDate'] = $tracker->metrics->first()->measured_on->toFormattedDateString();
        $data['maxDate'] = $tracker->metrics->last()->measured_on->toFormattedDateString();

        $data['trackers'] = $this->getOrderedTrackers();

        return view('reporter.index', $data);
    }

    protected function getTrackerWithOrderedMetrics($metric) {
        return Tracker::where('user_id', Auth::user()->id)
            ->where('metric', $metric)
            //->with('metricsOrdered') // can't get this to work
            ->with(['metrics' => function ($query) {
                $query->orderBy('measured_on');
            }])
            ->firstOrFail();
    }

    protected function getOrderedTrackers() {
        return Tracker::where('user_id', Auth::user()->id)
            ->orderBy('metric')
            ->get();
    }

    // a graph series is an array of points (x,y)
    protected function formatMetricsAsGraphSeries($metrics) {
        // Values are stored as strings. We return them as-is
        // so the browser can convert them using the user's locale
        $seriesData = $metrics->map(function ($item) {
            return [
                'metric_id' => $item->id,
                'tracker_id' => $item->tracker_id,
                // return  datetime in milliseconds (for javascript)
                'x' => $item->measured_on->valueOf(),
                'y' => $item->value,
            ];
        });

        return $seriesData;
    }

    // a graph series is an array of points (x,y)
    protected function formatGoalAsGraphSeries($tracker) {
        // if user has no goals... well, I understand, I certainly can't point fingers.
        if (empty($tracker->goal_value)) {
            return [];
        }

        // If we have no goal end date, then the Y value will simply be a
        // horizontal line at the goal's value, starting at the date of the
        // first metric and ending at the date of the last metric.
        //
        // If we have a goal end date, then start the series at the date and
        // value of the first metric, and end it at the date and value of the
        // goal.
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

        return [$start,  $end];
    }
}
