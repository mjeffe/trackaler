<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateMetricRequest;

class TrackerController extends Controller {

    public function create() {
        return view('tracker');
    }

    public function store(CreateMetricRequest $request) {
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
