<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name', 'club_id', 'deleted_at'
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function get_activity_message($activity_type){

        $message = '';

        if($activity_type == 'CREATED'){
            $message = "Created a new section \"{$this->name}\"";
        }elseif($activity_type == 'UPDATED'){
            $message = "Updated \"{$this->name}\" section";
        }elseif($activity_type == 'DELETED'){
            $message = "Deleted section \"{$this->name}\"";
        }

        return $message;
    }
}
