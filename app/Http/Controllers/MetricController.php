<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Metric;
use App\Models\Tracker;
use App\Services\MetricService;
use App\Services\TrackerService;
use App\Http\Requests\Tracker\CreateMetricRequest;

class MetricController extends Controller {

    public function __construct(MetricService $metricService, TrackerService $trackerService) {
        $this->metricService = $metricService;
        $this->trackerService = $trackerService;
    }

    /*
    public function index() {
        $metrics = $this->service->getAll();

        return view('metrics.index', compact('metrics'));
    }
     */

    public function create(Request $request, $tracker_id) {
        $tracker = $this->trackerService->getOne($tracker_id);
        $metric = new Metric();

        return view('metrics.create')->with(compact('tracker', 'metric'));
    }

    public function edit(Request $request, $tracker_id, $metric_id) {
        $tracker = $this->trackerService->getOne($tracker_id);
        $metric = $this->metricService->getOne($tracker_id, $metric_id);

        return view('metrics.create')->with(compact('tracker', 'metric'));
    }

    public function store(CreateMetricRequest $request, $tracker_id) {
        $request->flash();

        $this->metricService->create($tracker_id, $request->all());

        return $this->create($request, $tracker_id);
    }

    public function update(CreateMetricRequest $request, $tracker_id, $metric_id) {
        $request->flash();

        $this->metricService->update($tracker_id, $metric_id, $request->all());

        return redirect(route('reporter.metrics', $tracker_id));
    }

    public function delete(Request $request, $tracker_id, $metric_id) {
        $this->metricService->delete($tracker_id, $metric_id, $request->all());

        return redirect()->route('reporter.metrics', [
            'tracker_id' => $tracker_id,
            'metric_id' => $metric_id
        ]);
    }
}
