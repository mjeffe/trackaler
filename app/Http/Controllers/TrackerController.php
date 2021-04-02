<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateTrackerRequest;

class TrackerController extends Controller {

    public function index() {
        $trackers = Tracker::where('user_id', Auth::user()->id)->get();

        $data = [
            'trackers' => $trackers,
        ];

        return view('tracker.index', $data);
    }

    public function create() {
        $tracker = new Tracker();

        return view('tracker.create', compact('tracker'));
    }

    public function edit(Request $request, $tracker_id) {
        $tracker = Tracker::where('user_id', Auth::user()->id)->findOrFail($tracker_id);

        return view('tracker.create', compact('tracker'));
    }

    public function store(CreateTrackerRequest $request) {
        $request->flash();
        $tracker = Tracker::where('user_id', Auth::user()->id)
            ->where('metric', $request->metric)
            ->first();

        if (!empty($tracker)) {
            return back()->withError('That tracker already exists')->withInput();
        }

        $tracker = new Tracker();

        $tracker->fill($request->all());
        $tracker->user_id = Auth::user()->id;
        $tracker->save();

        return $this->index();
    }

    public function update(CreateTrackerRequest $request, $tracker_id) {
        $request->flash();
        $tracker = Tracker::where('user_id', Auth::user()->id)->findOrFail($tracker_id);

        $tracker->fill($request->all());
        $tracker->user_id = Auth::user()->id;
        $tracker->save();

        return $this->index();
    }

    public function delete(Request $request, $tracker_id) {
        $tracker = Tracker::where('user_id', Auth::user()->id)->find($tracker_id);

        if (empty($tracker)) {
            return back()->withError('You do not have permissions on that tracker')->withInput();
        }

        $tracker->delete();

        return $this->index();
    }
}
