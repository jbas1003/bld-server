<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Events;
use App\Models\Members;
use App\Models\Addresses;
use App\Models\Attendance;
use App\Models\Occupation;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use App\Models\ContactNumbers;
use Illuminate\Support\Facades\DB;
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
                'middle_name' => 'nullable|string|max:191',
                'last_name' => 'required|string|max:191',
                'nickname' => 'nullable|string|max:191',
                'birthday' => 'nullable|string|max:191',
                'gender' => 'nullable|string|max:191',
                'civil_status' => 'nullable|string|max:191',
                'spouse_member_id' => 'nullable|integer',
                'religion' => 'nullable|string|max:191',
                'baptism' => 'nullable|string',
                'confirmation' => 'nullable|string',
                'member_status_id' => 'nullable|integer',
                'created_by' => 'required|integer',

                // END: Table Members Data

                // START: Table Address Data

                'member_address_line1' => 'nullable|string|max:191',
                'member_address_line2' => 'nullable|string|max:255',
                'member_city' => 'nullable|string|max:191',

                // END: Table Address Data

                // START: Table ContactNumbers Data

                'member_mobile' => 'nullable|string|max:20',

                // END: Table ContactNumbers Data

                // START: Table Emails Data

                'email' => 'nullable|string|max:191',

                // END: Table Emails Data

                // START: Table Occupations Data

                'occupation_name' => 'nullable|string|max:191',
                'specialty' => 'nullable|string|max:191',
                'company' => 'nullable|string|max:191',
                'company_address_line1' => 'nullable|string|max:191',
                'company_address_line2' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:191',

                // END: Table Occupations Data
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages(),
                ], 422);
            } else {
                $memberExist = ContactInfo::join('tblmembers', 'tblcontact_infos.member_id', '=', 'tblmembers.member_id')
                                          ->join('tbladdresses', 'tblcontact_infos.address_id', '=', 'tbladdresses.address_id')
                                          ->join('tblcontact_numbers', 'tblcontact_infos.contactNumber_id', '=', 'tblcontact_numbers.contactNumber_id')
                                          ->join('tblemails', 'tblcontact_infos.email_id', '=', 'tblemails.email_id')
                                          ->first();

                if ($memberExist) {
                    // if ((($memberExist->first_name === $request->first_name) && ($memberExist->middle_name === $request->middle_name) && ($memberExist->last_name === $request->last_name)) || ($memberExist->email === $request->email) || ($memberExist->mobile === $request->mobile)) {
                    //     return response()->json([
                    //         'status' => 422,
                    //         'message' => 'Please check name, email, or mobile number. One of these info might already exist, or might have not existed.'
                    //     ], 422);
                    // } else {
                        
                        $member = Members::create([
                            'first_name' => $request->first_name,
                            'middle_name' => $request->middle_name,
                            'last_name' => $request->last_name,
                            'nickname' => $request->nickname,
                            'birthday' => $request->birthday,
                            'gender' => $request->gender,
                            'civil_status' => $request->civil_status,
                            'spouse_member_id' => $request->spouse_member_id,
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
                            'member_id' => $member->member_id,
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
                                'status' => 422,
                                'message' => 'Server Error.'
                            ], 422);
                        }
                    // }
                } else {
                    $getEvent = Events::where('event_name', $request->event_name)->first();
                        
                    $member = Members::create([
                        'first_name' => $request->first_name,
                        'middle_name' => $request->middle_name,
                        'last_name' => $request->last_name,
                        'nickname' => $request->nickname,
                        'birthday' => $request->birthday,
                        'gender' => $request->gender,
                        'civil_status' => $request->civil_status,
                        'spouse_member_id' => $request->spouse_member_id,
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
                        'member_id' => $member->member_id,
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
                            'message' => 'Server Error.'
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
            $getAllMembers = ContactInfo::join('tblmembers', 'tblcontact_infos.member_id', '=', 'tblmembers.member_id')
                                ->join('tbladdresses', 'tblcontact_infos.address_id', '=', 'tbladdresses.address_id')
                                ->join('tblcontact_numbers', 'tblcontact_infos.contactNumber_id', '=', 'tblcontact_numbers.contactNumber_id')
                                ->join('tblemails', 'tblcontact_infos.email_id', '=', 'tblemails.email_id')
                                ->join('tbloccupations', 'tblcontact_infos.occupation_id', '=', 'tbloccupations.occupation_id')
                                ->select('tblmembers.member_id', 'tblmembers.first_name', 'tblmembers.middle_name', 'tblmembers.last_name', 'tblmembers.nickname',
                                'tblcontact_numbers.mobile', 'tblemails.email', 'tblmembers.birthday', 'tblmembers.gender', 'tblmembers.civil_status',
                                'tblmembers.religion', 'tblmembers.baptism', 'tblmembers.confirmation', 'tbladdresses.address_line1', 'tbladdresses.address_line2', 'tbladdresses.city')
                                ->get();
              
            
            if ($getAllMembers->count() > 0) {
                return response()->json([
                    'status' => 200,
                    'body' => $getAllMembers
                ], 200);
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => 'No records found.'
                ], 422);
            }

            return $getAllMembers;
            
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
        try {
            $validator = Validator::make($request->all(), [
                // START: Table Members Data

                'first_name' => 'required|string|max:191',
                'middle_name' => 'nullable|string|max:191',
                'last_name' => 'required|string|max:191',
                'nickname' => 'nullable|string|max:191',
                'birthday' => 'nullable|string|max:191',
                'gender' => 'nullable|string|max:191',
                'civil_status' => 'nullable|string|max:191',
                'spouse_member_id' => 'nullable|integer',
                'religion' => 'nullable|string|max:191',
                'baptism' => 'nullable|string',
                'confirmation' => 'nullable|string',
                'member_status_id' => 'nullable|integer',

                // END: Table Members Data

                // START: Table Address Data

                'member_address_line1' => 'nullable|string|max:191',
                'member_address_line2' => 'nullable|string|max:255',
                'member_city' => 'nullable|string|max:191',

                // END: Table Address Data

                // START: Table ContactNumbers Data

                'member_mobile' => 'nullable|string|max:20',

                // END: Table ContactNumbers Data

                // START: Table Emails Data

                'email' => 'nullable|string|max:191',

                // END: Table Emails Data

                // START: Table Occupations Data

                'occupation_name' => 'nullable|string|max:191',
                'specialty' => 'nullable|string|max:191',
                'company' => 'nullable|string|max:191',
                'company_address_line1' => 'nullable|string|max:191',
                'company_address_line2' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:191',

                // END: Table Occupations Data
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages(),
                ], 422);
            } else {
                $memberExist = Members::where('member_id', $request->member_id);

                if ($memberExist) {
                    $getMember = ContactInfo::where('member_id', $request->member_id)->first();
                    
                    $member = Members::where('member_id', $getMember->member_id)
                            ->update([
                                'first_name' => $request->first_name,
                                'middle_name' => $request->middle_name,
                                'last_name' => $request->last_name,
                                'nickname' => $request->nickname,
                                'birthday' => $request->birthday,
                                'gender' => $request->gender,
                                'civil_status' => $request->civil_status,
                                'spouse_member_id' => $request->spouse_member_id,
                                'religion' => $request->religion,
                                'baptism' => $request->baptism,
                                'confirmation' => $request->confirmation,
                                'member_status_id' => $request->member_status_id,
                                // 'updated_by' => $request->updated_by,
                                // 'updated_on' => now()
                            ]);
    
                    $address = Addresses::where('address_id', $getMember->address_id)
                            ->update([
                                'address_line1' => $request->member_address_line1,
                                'address_line2' => $request->member_address_line2,
                                'city' => $request->member_city,
                                // 'updated_by' => $request->updated_by,
                                // 'updated_on' => now()
                            ]);

                    $contactNumber = ContactNumbers::where('contactNumber_id', $getMember->contactNumber_id)
                            ->update([
                                'mobile' => $request->member_mobile,
                                // 'updated_by' => $request->updated_by,
                                // 'updated_on' => now()
                            ]);

                    $email = Emails::where('email_id', $getMember->email_id)
                            ->update([
                                'email' => $request->email,
                                // 'updated_by' => $request->updated_by,
                                // 'updated_on' => now()
                            ]);

                    $occupation = Occupation::where('occupation_id', $getMember->occupation_id)
                            ->update([
                                'occupation_name' => $request->occupation_name,
                                'specialty' => $request->specialty,
                                'company' => $request->company,
                                'address_line1' => $request->company_address_line1,
                                'address_line2' => $request->company_address_line2,
                                'city' => $request->city,
                                // 'updated_by' => $request->updated_by,
                                // 'updated_on' => now()
                            ]);

                    return response()->json([
                        'status' => 200,
                        'message' => 'Record successfully updated!'
                    ], 200);

                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Members $members)
    {
        //
    }
}
