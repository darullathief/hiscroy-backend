<?php

namespace App\Models;

use App\Models\Story;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        "story_id",
        "title",
        "content",
        'sequence',
    ];

    public function story() : BelongsTo
    {
        return $this->belongsTo(Story::class);
    }
}

