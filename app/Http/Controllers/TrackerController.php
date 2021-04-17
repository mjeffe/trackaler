<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Tracker;
use App\Services\TrackerService;
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
        $request->flash();
        try {
            $this->service->create($request->all());
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

        return $this->index();
    }

    public function update(CreateTrackerRequest $request, $tracker_id) {
        $request->flash();
        try {
            $this->service->update($tracker_id, $request->all());
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

        return $this->index();
    }

    public function delete(Request $request, $tracker_id) {
        try {
            $this->service->delete($tracker_id);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

        return $this->index();
    }
}
