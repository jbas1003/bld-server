<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Members;
use App\Models\Addresses;
use App\Models\Occupation;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use App\Models\ContactNumbers;
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
                // START: Table Members Data

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
                'created_by' => 'required|integer',

                // END: Table Members Data

                // START: Table Address Data

                'member_address_line1' => 'nullable|string|max:191',
                'member_address_line2' => 'nullable|string|max:255',
                'member_city' => 'required|string|max:191',

                // END: Table Address Data

                // START: Table ContactNumbers Data

                'member_mobile' => 'required|string|max:20',

                // END: Table ContactNumbers Data

                // START: Table Emails Data

                'email' => 'required|string|max:191',

                // END: Table Emails Data

                // START: Table Occupations Data

                'occupation_name' => 'required|string|max:191',
                'specialty' => 'nullable|string|max:191',
                'company' => 'nullable|string|max:191',
                'company_address_line1' => 'nullable|string|max:191',
                'company_address_line2' => 'nullable|string|max:255',
                'company_city' => 'required|string|max:191',

                // END: Table Occupations Data
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ], 422);
            } else {
                $memberExist = Members::where('first_name', $request->first_name)
                    ->orWhere('middle_name', $request->middle_name)
                    ->orWhere('last_name', $request->last_name)
                    ->get();
                $emailExist = Emails::where('email', $request->email)->get();
                $contactNumberExist = ContactNumbers::where('mobile', $request->mobile)->get();
                
                if (($memberExist->count() > 0) || ($emailExist->count() > 0) || ($contactNumberExist->count() > 0)) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Please check name, email, or mobile number. One of these info might already exist.'
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
    
                    $address = Addresses::create([
                        'address_line1' => $request->member_address_line1,
                        'address_line2' => $request->member_address_line2,
                        'city' => $request->member_city,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);

                    $contactNumber = ContactNumbers::create([
                        'mobile' => $request->member_mobile,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);

                    $email = Emails::create([
                        'email' => $request->email,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);

                    $occupation = Occupation::create([
                        'occupation_name' => $request->occupation_name,
                        'specialty' => $request->specialty,
                        'company' => $request->company,
                        'address_line1' => $request->company_address_line1,
                        'address_line2' => $request->company_address_line2,
                        'city' => $request->city,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);

                    $contactInfo = ContactInfo::create([
                        'member_id' => $member->id,
                        'address_id' => $address->id,
                        'contactNumber_id' => $contactNumber->id,
                        'email_id' => $email->id,
                        'occupation_id' => $occupation->id,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);

                    if ($contactInfo) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Record successfully added!'
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 500,
                            'errors' => 'Server Error.'
                        ], 500);
                    }
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
