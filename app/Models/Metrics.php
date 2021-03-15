<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metrics extends Model
{
    use HasFactory;

    protected $fillable = [
        'metric',
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
