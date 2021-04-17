<?php

namespace App\Services;

use App\Services\BaseService;
use App\Services\TrackerService;

class ReporterService extends BaseService {

    public function __construct() {
        $this->trackerService = resolve(TrackerService::class);
    }

    // a graph series is an array of points (x,y)
    public function formatMetricsAsGraphSeries($metrics) {
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
    public function formatGoalAsGraphSeries($tracker) {
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
            'y' => $tracker->goal_date
                        ? $tracker->metrics->first()->value
                        : $tracker->goal_value
        ];
        $end = [
            'x' => $tracker->goal_date
                        ? $tracker->goal_date->valueOf()
                        : $tracker->metrics->last()->measured_on->valueOf(),
            'y' => $tracker->goal_value
        ];

        return [$start,  $end];
    }
}
