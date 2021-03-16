<?php

namespace App\Http\Controllers;

use App\Models\Metrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetricsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $metrics = Metrics::where('user_id', Auth::user()->id)->get();

        return view('reporter', ['data' => $metrics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $model = new  Metrics();

        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->save();

        return view('tracker');
    }

    /**
     * Display the specified resource type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $metric) {
        $metrics = Metrics::where('user_id', Auth::user()->id)->where('metric', $metric)->get();

        return view('reporter', ['data' => $metrics]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Metrics  $metrics
     * @return \Illuminate\Http\Response
     */
    public function edit(Metrics $metrics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Metrics  $metrics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Metrics $metrics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Metrics  $metrics
     * @return \Illuminate\Http\Response
     */
    public function destroy(Metrics $metrics)
    {
        //
    }
}
