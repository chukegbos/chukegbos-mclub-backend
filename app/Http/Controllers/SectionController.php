<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Log;
use App\Models\Club;
use Validator;
use GuzzleHttp\Client;
use Auth;

class SectionController extends BaseController
{
    private $club_id;
    private $user_id;

    public function __construct()
    {
        $this->middleware('api');
        $this->club_id = Auth()->user()->club_id;
        $this->user_id = Auth()->user()->id;
    }

    public function index()
    {
        $success = Section::where('club_id', $this->club_id)->where('deleted_at', NULL)->paginate(20);

        if($success){ 
            return $this->sendResponse($success, 'Section fetched successfully.');
        } 
        else{ 
            return $this->sendError('Not Fetched.', ['error'=>'section could not be fetched, try again.']);
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

        $section = Section::create([
            'club_id' => $this->club_id,
            'name' => $request->name,
        ]);

        if ($section) {
            $success = Log::log($this->club_id, $this->user_id, 'CREATED', $section);
        }

        if($success){ 
            return $this->sendResponse($success, 'Section created successfully.');
        } 
        else{ 
            return $this->sendError('Not Created.', ['error'=>'section could not be created, try again.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:25',
        ]);

        $section = Section::where('club_id', $this->club_id)->where('deleted_at', NULL)->find($id);
        if(!$section){ 
            return $this->sendError('Not Found.', ['error'=>'Section not found, try again.']);
        }

        else {
            $done = $section->update([
                'name' => $request->name,
            ]);

            if ($done) {
                $success = Log::log($this->club_id, $this->user_id, 'UPDATED', $section);
            }

            if($success){ 
                return $this->sendResponse($success, 'Section updated successfully.');
            } 
            else{ 
                return $this->sendError('Not Created.', ['error'=>'Section could not be updated, try again.']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        foreach ($request->selected as $id) {
            $section = Section::where('club_id', $this->club_id)->where('deleted_at', NULL)->find($id);
            if ($section) {
                $success = Log::log($this->club_id, $this->user_id, 'DELETED', $section);
                if ($success) {
                    Section::Destroy($id);
                }
            }
        }
        $success = true;
        return $this->sendResponse($success, 'Selected sections deleted successfully.');
    }
}
