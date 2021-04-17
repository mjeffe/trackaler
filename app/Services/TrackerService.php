<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Tracker;
use App\Services\BaseService;
use App\Exceptions\DuplicateTrackerException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrackerService extends BaseService {

    public function getAll() {
        return Tracker::where('user_id', Auth::user()->id)->get();
    }

    public function getOne($tracker_id) {
        return Tracker::where('user_id', Auth::user()->id)->findOrFail($tracker_id);
    }

    public function create($data) {
        $this->validateCanCreateTracker($data['metric']);

        $tracker = new Tracker();
        $tracker->fill($data);
        $tracker->user_id = Auth::user()->id;
        $tracker->save();

        return $tracker;
    }

    public function update($tracker_id, $data) {
        $tracker = $this->getOne($tracker_id);

        $tracker->fill($data);
        $tracker->save();

        return $tracker;
    }

    public function delete($tracker_id) {
        DB::transaction(function () use($tracker_id) {
            $tracker = $this->getOne($tracker_id);

            $tracker->delete();

            DB::Table('metrics')
                ->where('user_id', Auth::user()->id)
                ->where('tracker_id', $tracker_id)
                ->delete();
        });
    }

    protected function validateCanCreateTracker($metric) {
        $exists = Tracker::where('user_id', Auth::user()->id)
            ->where('metric', $metric)
            ->first();

        if ($exists) {
            throw new DuplicateTrackerException("Cannot create duplicate tracker for $metric metric");
        }
    }

}
