<?php

namespace App\Models;

use App\Models\Series;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;
    
    protected $table = 'story';
    protected $fillable = [
        'title',
        'description',
        'location',
        'date_start',
    ];

    protected $attributes = [
        'date_finish' => null,
    ];
    
    public function series() : BelongsToMany
    {
        return $this->belongsToMany(Series::class, 'series_user', 'story_id', 'series_id');
    }
}
