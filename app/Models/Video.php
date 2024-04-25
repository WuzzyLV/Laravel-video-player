<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;

    protected $visible = ['id', 'url', 'title', 'description'];

    protected $fillable = [
        'title',
        'description',
        'filename',
        'file_path',
        'length',
        'is_public',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function playlist(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount(): int
    {
        return $this->views()->sum('views');
    }

    public function uniqueViewCount(): int
    {
        return $this->views()->count();
    }
}
