<?php

namespace App\Models;

use App\Models\Events;
use App\Models\Series;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        return $this->belongsToMany(Series::class, 'series_story', 'story_id', 'series_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Events::class);
    }
}
