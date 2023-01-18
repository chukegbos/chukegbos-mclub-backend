<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MemberCard extends Model
{
    protected $table = 'default_esc_member_card_numbers';

    protected $fillable = [
        'member_id', 'card_number'
    ];
}