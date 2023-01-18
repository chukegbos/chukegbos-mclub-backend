<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Member;

class MemberSection extends Model
{
    protected $table = 'default_esc_member_sections';
    protected $fillable = [
        'member_id', 'section_id', 'member'
    ];

    public function member()
    {
        $id = $this->attributes['member_id'];
        $member = Member::find($id);
        if ($member) {
            return $member;
        }
        else {
            return '';
        }
    }
}
