<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //START: Add Members 

        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:191',
                'middle_name' => 'required|string|max:191',
                'last_name' => 'required|string|max:191',
                'nickname' => 'required|string|max:191',
                'birthday' => 'required|string|max:191',
                'gender' => 'required|string|max:191',
                'religion' => 'required|string|max:191',
                'baptism' => 'required|boolean',
                'confirmation' => 'required|boolean',
                'member_status_id' => 'required|integer',
                'created_by' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ], 422);
            } else {
                $member = Members::create([
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'nickname' => $request->nickname,
                    'birthday' => $request->birthday,
                    'gender' => $request->gender,
                    'religion' => $request->religion,
                    'baptism' => $request->baptism,
                    'confirmation' => $request->confirmation,
                    'member_status_id' => $request->member_status_id,
                    'created_by' => $request->created_by,
                    'created_on' => now()
                ]);

                if ($member) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Record created successfully!'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 500,
                        'errors' => 'Server Error.'
                    ], 500);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        // END: Add Members
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //START: Show all members

        try {
            if ($request->member_id) {
                $getMember = Members::where('member_id', '=', $request->member_id)->get();

                if ($getMember->count() > 0) {
                    return response()->json([
                        'status' => 200,
                        'body' => $getMember
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'No record found.'
                    ], 404);
                }
            } else {
                $getMembers = Members::all();

                if ($getMembers->count() > 0) {
                    return response()->json([
                        'status' => 200,
                        'body' => $getMembers
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'No records found.'
                    ], 404);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        // END: Show all members
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Members $members)
    {
        //
    }
}
