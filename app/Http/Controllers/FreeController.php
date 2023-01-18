<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use DB;

class FreeController extends BaseController
{
    public function __construct()
    {
        
    }

    public function loadLGA($id)
    {   
        return DB::table('local_governments')->where('state_id' ,$id)->get();
    }
   
}
