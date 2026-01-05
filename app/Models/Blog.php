<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','slug','excerpt','content','image_url','published_at','is_published'
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
    ];
}
