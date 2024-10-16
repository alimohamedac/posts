<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer id
 * @property string name
 * @property string phone_number
 * @property string password
 * @property string|null verification_code
 * @property boolean is_verified
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 **/

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'verification_code',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('stats');
        });

        static::deleted(function () {
            Cache::forget('stats');
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

}
