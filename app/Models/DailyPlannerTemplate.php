<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPlannerTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan',
        'day',
        'title',
        'type',
        'description',
        'default_data',
    ];

    protected $casts = [
        'default_data' => 'array',
    ];
}
