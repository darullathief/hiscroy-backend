<?php

namespace App\Models;

use App\Models\Story;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Series extends Model
{
    use HasFactory;

    protected $fllable = [
        "title",
        "description",
        "location",
    ];

    public function story(): BelongsToMany
    {
        return $this->belongsToMany(Story::class, 'series_story', 'series_id', 'story_id');
    }
}
