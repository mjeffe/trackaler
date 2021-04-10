<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateMetricRequest;

class MetricController extends Controller {

    public function create(Request $request, $tracker_id) {
        $tracker = Tracker::where('user_id', Auth::user()->id)->findOrFail($tracker_id);
        $metric = new Metric();

        return view('metrics.create')->with(compact('tracker', 'metric'));
    }

    public function edit(Request $request, $tracker_id, $metric_id) {
        $tracker = Tracker::where('user_id', Auth::user()->id)->findOrFail($tracker_id);

        $metric = Metric::where('user_id', Auth::user()->id)
            ->where('tracker_id', $tracker_id)
            ->findOrFail($metric_id);

        return view('metrics.create')->with(compact('tracker', 'metric'));
    }

    public function update(CreateMetricRequest $request, $tracker_id, $metric_id) {
        $request->flash();
        $metric = Metric::with(['tracker'])
            ->where('user_id', Auth::user()->id)
            ->where('tracker_id', $tracker_id)
            ->findOrFail($metric_id);

        $metric->fill($request->all());
        $metric->user_id = Auth::user()->id;
        $metric->tracker_id = $tracker_id;
        $metric->save();

        return redirect(route('reporter.metrics', $tracker_id));
    }

    public function store(CreateMetricRequest $request, $tracker_id) {
        $tracker = Tracker::where('user_id', Auth::user()->id)->findOrFail($tracker_id);

        $model = new Metric();

        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->tracker_id = $tracker_id;
        $model->save();

        $request->flash();

        return $this->create($request, $tracker_id);
    }

    public function delete(Request $request, $tracker_id, $metric_id) {
        return 'Unimplemented';
        //return view('metrics.create');
    }
}
