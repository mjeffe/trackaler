<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateTrackerRequest;

class TrackerController extends Controller {

    public function index() {
        $trackers = Tracker::where('user_id', Auth::user()->id)
            ->get();

        $data = [
            'trackers' => $trackers,
        ];

        return view('tracker', $data);
    }

    public function create() {
        return view('tracker-create');
    }

    public function store(CreateTrackerRequest $request) {
        $request->flash();
        $tracker = Tracker::where('user_id', Auth::user()->id)
            ->where('metric', $request->metric)
            ->first();

        if (!empty($tracker)) {
            return back()->withError('That tracker already exists')->withInput();
        }

        $model = new Tracker();

        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->save();

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

    public function edit(Request $request, $tracker_id) {
        return 'Unimplemented';
    }
}
