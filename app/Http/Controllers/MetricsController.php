<?php

namespace App\Http\Controllers;

use App\Models\Metrics;
use Illuminate\Http\Request;

class MetricsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        dd($request->all());
        //$someName = $request->someName;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Metrics  $metrics
     * @return \Illuminate\Http\Response
     */
    public function show(Metrics $metrics)
    {
        //
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
