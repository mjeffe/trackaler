<?php

namespace App\Models;

use App\Models\User;
use App\Models\Metrics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model {
    use HasFactory;

    protected $fillable = [
        'metric',
        'description',
        'units',
        'goal_value',
        'goal_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'goal_date' => 'datetime',
    ];

    /*
     * relationships
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function metrics() {
        return $this->hasMany(Metric::class);
    }
    public function metricsOrdered() {
        return $this->hasMany(Metric::class)->orderBy('measured_on');
    }
    /* Or use this in the controller
    ->with(['metrics' => function ($query) {
        $query->orderBy('measured_on');
    }])
     */

}
