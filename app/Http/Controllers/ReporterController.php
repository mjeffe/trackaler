<?php

namespace App\Http\Controllers;

use App\Models\Metrics;
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
        $metrics = Metrics::where('user_id', Auth::user()->id)
            ->where('metric', $metric)
            ->orderBy('measured_on')
            ->get();

        $data = [
            'metric' => $metric,
            'data' => $metrics,
        ];

        return view('reporter', $data);
    }
}
