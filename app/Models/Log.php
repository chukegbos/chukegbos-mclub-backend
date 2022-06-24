<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'description', 'activity_type', 'item_id', 'club_id', 'user_id', 'deleted_at'
    ];

    protected $dates = [
        'deleted_at',
    ];

    public static function log($club_id, $user_id, $activity_type, $item){
        return Log::create([
            'club_id' => $club_id,
            'user_id' => $user_id,
            'activity_type' => $activity_type,
            'description' => $item->get_activity_message($activity_type),
            'item_id' => $item ? $item->id : NULL,
        ]);
    }
}
