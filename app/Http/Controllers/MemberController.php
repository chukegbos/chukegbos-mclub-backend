<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Log;
use App\Models\Type;
use App\Models\Member;
use App\Models\MemberCard;
use App\Models\MemberSection;
use Validator;
use GuzzleHttp\Client;
use Auth;
use DB;

class MemberController extends BaseController
{
    private $club_id;
    private $user_id;

    public function __construct()
    {
        $this->club_id = Auth('api')->user()->club_id;
        $this->user_id = Auth('api')->user()->id;
    }

    public function details(Request $request)
    {
        $params = [];
        $params['member_types'] = Type::where('club_id', $this->club_id)->where('deleted_at', NULL)->latest()->get();
        $params['sections'] = Section::where('club_id', $this->club_id)->where('deleted_at', NULL)->get();
        $params['states'] = DB::table('states')->get();
        
        if($params){ 
            return $this->sendResponse($params, 'Details fetched successfully.');
        } 
        else{ 
            return $this->sendError('Not Fetched.', ['error'=>'details could not be fetched, try again.']);
        }
    }

    public function index(Request $request)
    {
        $success = Member::where('club_id', $this->club_id)->where('deleted_at', NULL)->latest()->get();
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
            'lastname' => 'required|string|max:191',
            'firstname' => 'required|string|max:191',
            'email' => 'required|string|max:191|email|unique:users',
            'phone' => 'required|string|max:19',
            'state' => 'required',
            'address' => 'required|string|max:191',
            'member_type' => 'required',
            'membership_id' => 'required'
        ]);

        set_time_limit(0);
        $getMember = Member::where('deleted_at', NULL)->where('membership_id', $request->membership_id)->first();
        if ($getMember) {
            $error = 'Member with membership ID #'.$request->membership_id.' already exist.';
            return $this->sendError('Not Created.', ['error'=> $error]);
        }

        $member = Member::create([
            'club_id' => $this->club_id,
            'membership_id' => $request['membership_id'],
            'lastname' => $request['lastname'],
            'firstname' => $request['firstname'],
            'middlename' => $request['middlename'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'state' => $request['state'],
            'city' => $request['lag'],
            'gender' => $request['gender'],
            'dob' => $request['dob'],
            'entrance_date' => $request['entrance_date'],
            'address' => $request['address'],
            'lga' => $request['lga'],
            'member_type' => $request['member_type'],
            'image' => $request['image'],
        ]);

        if($request->card_numbers){
            foreach ($request->card_numbers as $item) {
                $memberCard = MemberCard::create([
                    'member_id' => $member->id,
                    'card_number' => $item['card_number'],
                ]);
            }
        }
        
        if($request->sections){
            foreach ($request->sections as $section_id) {
                MemberSection::create([
                    'member_id' => $member->id,
                    'section_id' => $section_id,
                ]);
            }
        }

        if ($member) {
            $success = Log::log($this->club_id, $this->user_id, 'CREATED', $member);
        }

        if($success){ 
            return $this->sendResponse($success, 'Member created successfully.');
        } 
        else{ 
            return $this->sendError('Not Created.', ['error'=>'Member could not be created, try again.']);
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
