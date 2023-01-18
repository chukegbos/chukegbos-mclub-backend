<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'firstname', 'club_id', 'membership_id', 'lastname', 'middlename', 'email',	'phone', 'address', 'city', 'state', 'member_type', 'entrance_date', 'gender', 'dob', 'image', 'lga'
    ];

    protected $dates = [
        'deleted_at', 'dob', 'entrance_date'
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
