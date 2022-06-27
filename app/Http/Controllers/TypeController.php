<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Log;
use App\Models\Club;
use Validator;
use GuzzleHttp\Client;
use Auth;

class TypeController extends BaseController
{
    private $club_id;
    private $user_id;

    public function __construct()
    {
        $this->middleware('api');
        $this->club_id = Auth('api')->user()->club_id;
        $this->user_id = Auth('api')->user()->id;
    }

    public function index()
    {
        $success = Type::where('club_id', $this->club_id)->where('deleted_at', NULL)->paginate(20);

        if($success){ 
            return $this->sendResponse($success, 'Type fetched successfully.');
        } 
        else{ 
            return $this->sendError('Not Fetched.', ['error'=>'Type could not be fetched, try again.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:25',
        ]);

        $type = Type::create([
            'club_id' => $this->club_id,
            'name' => $request->name,
        ]);

        if ($type) {
            $success = Log::log($this->club_id, $this->user_id, 'CREATED', $type);
        }

        if($success){ 
            return $this->sendResponse($success, 'Type created successfully.');
        } 
        else{ 
            return $this->sendError('Not Created.', ['error'=>'Type could not be created, try again.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:25',
        ]);

        $type = Type::where('club_id', $this->club_id)->where('deleted_at', NULL)->find($id);
        if(!$type){ 
            return $this->sendError('Not Found.', ['error'=>'Member type not found, try again.']);
        }

        else {
            $done = $type->update([
                'name' => $request->name,
            ]);

            if ($done) {
                $success = Log::log($this->club_id, $this->user_id, 'UPDATED', $type);
            }

            if($success){ 
                return $this->sendResponse($success, 'Member type updated successfully.');
            } 
            else{ 
                return $this->sendError('Not Created.', ['error'=>'Member type could not be updated, try again.']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        foreach ($request->selected as $id) {
            $type = Type::where('club_id', $this->club_id)->where('deleted_at', NULL)->find($id);
            if ($type) {
                $success = Log::log($this->club_id, $this->user_id, 'DELETED', $type);
                if ($success) {
                    Type::Destroy($id);
                }
            }
        }
        $success = true;
        return $this->sendResponse($success, 'Selected member types deleted successfully.');
    }
}
