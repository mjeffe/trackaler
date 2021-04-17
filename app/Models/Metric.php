<?php

namespace App\Models;

use App\Models\Tracker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metric extends Model {
    use HasFactory;

    protected $fillable = [
        'value',
        'measured_on',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'measured_on' => 'datetime',
    ];

    /*
     * relationships
     */
    public function tracker() {
        return $this->belongsTo(Tracker::class);
    }
}
