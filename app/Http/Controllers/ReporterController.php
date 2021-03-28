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
        $tracker = Tracker::where('name', $metric)
            ->with('metrics')
            ->firstOrFail();

        $data = [
            'metric' => $metric,
            'data' => $tracker->metrics,
        ];

        return view('reporter', $data);
    }
}
