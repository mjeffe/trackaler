<?php

namespace App\Http\Controllers;

use App\Models\Metrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateMetricRequest;

class MetricsController extends Controller {

    public function index() {
        return view('reporter', [
            'data' => [],
        ]);
    }

    public function show(Request $request, $metric) {
        $metrics = Metrics::where('user_id', Auth::user()->id)
            ->where('metric', $metric)
            ->orderBy('measured_on')
            ->get();

        $data = [
            'metric' => $metric,
            'data' => $metrics,
        ];
        //dd($data);
        return view('reporter', $data);
    }

    public function create() {
        return view('tracker');
    }

    public function store(CreateMetricRequest $request) {
        $model = new  Metrics();

        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->save();

        $request->flash();
        return view('tracker');
        // on error
        //return back()->withInput();
    }
}
