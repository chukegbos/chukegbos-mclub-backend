<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Club;
use Auth;
use DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ClubController extends BaseController
{

    public function __construct()
    {
        $this->club_id = Auth('api')->user()->club_id;
    }

    private function school(){
        return Club::find($this->club_id);
    }

    public function index()
    {
        $params = [];
      
        return $params;
    }
}
