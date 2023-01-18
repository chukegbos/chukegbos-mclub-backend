<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\User;

class Payment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'club_id', 'product_id', 'amount', 'type'
    ];
}