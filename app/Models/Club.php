<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'code', 'address', 'phone', 'email', 'logo', 'deleted_at'
    ];

    protected $dates = [
        'deleted_at',
    ];
}
