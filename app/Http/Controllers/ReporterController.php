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
        $tracker = Tracker::where('user_id', Auth::user()->id)
            ->where('metric', $metric)
            //->with('metricsOrdered') // can't get this to work
            ->with(['metrics' => function ($query) {
                $query->orderBy('measured_on');
            }])
            ->firstOrFail();

        $trackers = Tracker::where('user_id', Auth::user()->id)
            ->orderBy('metric')
            ->get();

        return view('reporter.index', compact('tracker', 'trackers'));
    }
}
