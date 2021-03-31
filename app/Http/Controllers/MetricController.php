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

        return view('metric-create')->with('tracker', $tracker);
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

    public function delete(Request $request, $metric_id) {
        return 'Unimplemented';
        //return view('metric-create');
    }

    public function edit(Request $request, $metric_id) {
        return 'Unimplemented';
        //return view('metric-create');
    }
}
