<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Tracker;
use App\Services\BaseService;
use App\Services\TrackerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MetricService extends BaseService {

    public function getAll($tracker_id) {
        $this->authorize($tracker_id);

        return Metric::where('tracker_id', $tracker_id)->get();
    }

    public function getOne($tracker_id, $metric_id) {
        $this->authorize($tracker_id);

        return Metric::where('tracker_id', $tracker_id)->findOrFail($metric_id);
    }

    public function create($tracker_id, $data) {
        $this->authorize($tracker_id);

        $metric = new Metric();

        $metric->fill($data);
        $metric->tracker_id = $tracker_id;
        $metric->save();

        return $metric;
    }

    public function update($tracker_id, $metric_id, $data) {
        $metric = $this->getOne($tracker_id, $metric_id);

        $metric->fill($data);
        $metric->tracker_id = $tracker_id;
        $metric->save();

        return $metric;
    }

    public function delete($tracker_id, $metric_id) {
        $metric = $this->getOne($tracker_id, $metric_id);

        $metric->delete();
    }

    public function deleteAll($tracker_id) {
        $this->authorize($tracker_id);

        DB::Table('metrics')
            ->where('tracker_id', $tracker_id)
            ->delete();
    }

    protected function authorize($tracker_id) {
        // if we get it, it's ours
        $tracker = resolve(TrackerService::class)->getOne($tracker_id);
    }
}
