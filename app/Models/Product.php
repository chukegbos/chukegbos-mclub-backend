<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\User;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name', 'amount', 'payment_type', 'door_access', 'reoccuring_day', 'grace_period'
    ];

    public function types()
    {
        return $this->belongsToMany('App\Type');
    }
}