<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Tracker;
use App\Services\BaseService;
use App\Services\MetricService;
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

    public function getOneWithOrderedMetrics($tracker_id) {
        return Tracker::where('user_id', Auth::user()->id)
            ->with(['metrics' => function ($query) {
                $query->orderBy('measured_on');
            }])
            //->with('metricsOrdered') // can't get this to work
            ->findOrFail($tracker_id);
    }

    public function create($data) {
        $this->verifyTrackerMetricAvailable($data['metric']);

        $tracker = new Tracker();
        $tracker->fill($data);
        $tracker->user_id = Auth::user()->id;
        $tracker->save();

        return $tracker;
    }

    public function update($tracker_id, $data) {
        $tracker = $this->getOne($tracker_id);

        $this->verifyTrackerMetricAvailable($data['metric'], $tracker_id);

        $tracker->fill($data);
        $tracker->save();

        return $tracker;
    }

    public function delete($tracker_id) {
        DB::transaction(function () use($tracker_id) {
            $tracker = $this->getOne($tracker_id);

            resolve(MetricService::class)->deleteAll($tracker_id);

            $tracker->delete();
        });
    }

    protected function verifyTrackerMetricAvailable($metric, $excludeTrackerId = null) {
        $q = Tracker::where('user_id', Auth::user()->id)
            ->where('metric', $metric);

        if ($excludeTrackerId) {
            $q->where('id', '!=', $excludeTrackerId);
        }

        $exists = $q->first();

        if ($exists) {
            throw new DuplicateTrackerException("tracker for $metric metric exists");
        }
    }

}
