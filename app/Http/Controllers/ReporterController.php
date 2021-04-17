<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\Tracker;
use App\Services\TrackerService;
use App\Services\ReporterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateMetricRequest;

class ReporterController extends Controller {

    public function __construct(TrackerService $trackerService, ReporterService $reporterService) {
        $this->trackerService = $trackerService;
        $this->reporterService = $reporterService;
    }

    public function metrics(Request $request, $tracker_id) {
        $tracker = $this->trackerService->getOneWithOrderedMetrics($tracker_id);

        return view('reporter.metrics', compact('tracker'));
    }

    public function graph(Request $request, $tracker_id) {
        $tracker = $this->trackerService->getOneWithOrderedMetrics($tracker_id);
        $data['tracker'] = $tracker;

        if (count($tracker->metrics)) {
            $data['seriesData'] = $this->reporterService->formatMetricsAsGraphSeries($tracker->metrics);
            $data['goalSeriesData'] = $this->reporterService->formatGoalAsGraphSeries($tracker);

            $data['minDate'] = $tracker->metrics->first()->measured_on->toFormattedDateString();
            $data['maxDate'] = $tracker->metrics->last()->measured_on->toFormattedDateString();
        }

        return view('reporter.index', $data);
    }

}
