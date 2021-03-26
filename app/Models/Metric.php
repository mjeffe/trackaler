<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metric extends Model
{
    use HasFactory;

    protected $fillable = [
        'metric',
        'units',
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
}
