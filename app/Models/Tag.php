<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string name
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 **/

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
}
