<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracker;
use App\Services\TrackerService;
use App\Exceptions\DuplicateTrackerException;
use App\Http\Requests\Tracker\CreateTrackerRequest;

class TrackerController extends Controller {

    public function __construct(TrackerService $service) {
        $this->service = $service;
    }

    public function index() {
        $trackers = $this->service->getAll();

        return view('tracker.index', compact('trackers'));
    }

    public function create() {
        $tracker = new Tracker();

        return view('tracker.create', compact('tracker'));
    }

    public function edit(Request $request, $tracker_id) {
        $tracker = $this->service->getOne($tracker_id);

        return view('tracker.create', compact('tracker'));
    }

    public function store(CreateTrackerRequest $request) {
        try {
            $this->service->create($request->all());
        } catch (DuplicateTrackerException $e) {
            return back()->withError("A tracker for '{$request->metric}' already exists")->withInput();
        }

        $request->session()->flash('success', 'Yay');

        return $this->index();
    }

    public function update(CreateTrackerRequest $request, $tracker_id) {
        try {
            $this->service->update($tracker_id, $request->all());
        } catch (DuplicateTrackerException $e) {
            return back()->withError("A tracker for '{$request->metric}' already exists")->withInput();
        }

        $request->session()->flash('success', true);

        return $this->index();
    }

    public function delete(Request $request, $tracker_id) {
        $this->service->delete($tracker_id);

        $request->session()->flash('success', true);

        return $this->index();
    }
}
