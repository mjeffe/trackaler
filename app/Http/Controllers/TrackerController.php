<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateMetricRequest;

class TrackerController extends Controller {

    public function index() {
        $trackers = Tracker::where('user_id', Auth::user()->id)
            ->get();

        $data = [
            'trackers' => $trackers,
        ];

        return view('tracker', $data);
    }

    public function create() {
        return view('tracker-create');
    }

    public function store(CreateTrackerRequest $request) {
        $trackerId = Tracker::where('user_id', Auth::user()->id)
            ->where('name', $request->metric)
            ->firstOrFail()
            ->id;

        $model = new Metric();

        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->tracker_id = $trackerId;
        $model->save();

        $request->flash();
        return view('tracker');
        // on error
        //return back()->withInput();
    }

    // metric store
    public function metricStore(CreateMetricRequest $request) {
        $trackerId = Tracker::where('user_id', Auth::user()->id)
            ->where('name', $request->metric)
            ->firstOrFail()
            ->id;

        $model = new Metric();

        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->tracker_id = $trackerId;
        $model->save();

        $request->flash();
        return view('tracker');
        // on error
        //return back()->withInput();
    }
}
