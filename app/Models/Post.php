<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'cover_image',
        'pinned',
    ];

    protected static function boot()
    {
        static::saved(function () {
            Cache::forget('stats');
        });

        static::deleted(function () {
            Cache::forget('stats');
        });
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
