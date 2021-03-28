<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateMetricRequest;

class ReporterController extends Controller {

    public function index() {
        return view('reporter', [
            'data' => [],
        ]);
    }

    public function graph(Request $request, $metric) {
        $trackerId = Tracker::where('name', $metric)->firstOrFail()->id;

        $metrics = Metric::where('user_id', Auth::user()->id)
            ->where('tracker_id', $trackerId)
            ->orderBy('measured_on')
            ->get();

        $data = [
            'metric' => $metric,
            'data' => $metrics,
        ];

        return view('reporter', $data);
    }
}
