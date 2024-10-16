<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

/**
 * @property integer id
 * @property string title
 * @property string body
 * @property string|null cover_image
 * @property boolean pinned
 * @property integer user_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 **/

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'cover_image',
    ];

    protected $casts = [
        'pinned' => 'boolean',
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
