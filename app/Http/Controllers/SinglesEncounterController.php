<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Invite;
use App\Models\Members;
use App\Models\Addresses;
use App\Models\Attendance;
use App\Models\Occupation;
use App\Models\ContactInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContactNumbers;
use App\Models\EmergencyContact;
use App\Models\SinglesEncounter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SinglesEncounterController extends Controller
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
        try {
            $validator = Validator::make($request->all(), [
                // START: Table Members Data

                    'first_name' => 'nullable|string|max:191',
                    'middle_name' => 'nullable|string|max:191',
                    'last_name' => 'nullable|string|max:191',
                    'nickname' => 'nullable|string|max:191',
                    'birthday' => 'nullable|string|max:191',
                    'gender' => 'nullable|string|max:90',
                    'civil_status' => 'nullable|string|max:50',
                    'religion' => 'nullable|string|max:191',
                    'baptized' => 'nullable|string|max:30',
                    'confirmed' => 'nullable|string|max:30',
                    'member_status_id' => 'nullable|integer',
                    'created_by' => 'required|integer',

                // END: Table Members Data

                // START: Table Address Data

                    'member_addressLine1' => 'nullable|string|max:255',
                    'member_addressLine2' => 'nullable|string|max:255',
                    'member_city' => 'nullable|string|max:255',

                // END: Table Address Data

                // START: Table ContactNumbers Data

                    'member_mobile' => 'nullable|string|max:20',

                // END: Table ContactNumbers Data

                // START: Table Emails Data

                    'member_email' => 'nullable|string|max:191',

                // END: Table Emails Data

                // Start: Table Occupations Data

                    'occupation' => 'nullable|string|max:191',
                    'specialty' => 'nullable|string|max:191',
                    'company' => 'nullable|string|max:191',
                    'company_addressLine1' => 'nullable|string|max:255',
                    'company_addressLine2' => 'nullable|string|max:255',
                    'city' => 'nullable|string|max:191',

                // END: Table Occupations Data

                // START: Table EmergencyContacts Data

                    'emergency_contacts' => 'nullable|array',

                // END: Table EmergencyContacts Data

                // START: Table Invite Data

                    'inviter' => 'nullable|array',

                // END: Table Invite Data

                // START: Table Singles Encounter Data

                    'room' => 'nullable|string|max:50',
                    'tribe' => 'nullable|string|max:50',
                    'nation' => 'nullable|string|50',

                // END: Table Singles Encounter Data

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages(),
                ]);
            } else {
                $memberExist = ContactInfo::join('tblmembers', 'tblcontact_infos.member_id', '=', 'tblmembers.member_id')
                                          ->join('tbladdresses', 'tblcontact_infos.address_id', '=', 'tbladdresses.address_id')
                                          ->join('tblcontact_numbers', 'tblcontact_infos.contactNumber_id', '=', 'tblcontact_numbers.contactNumber_id')
                                          ->join('tblemails', 'tblcontact_infos.email_id', '=', 'tblemails.email_id')
                                          ->first();

                if ((($memberExist->first_name === $request->first_name) && ($memberExist->middle_name === $request->middle_name) && ($memberExist->last_name === $request->last_name)) || ($memberExist->email === $request->email) || ($memberExist->mobile === $request->mobile)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Please check name, email, or mobile number. One of these info might already exist, or might have not existed.'
                ], 422);
                } else {
                    // START: Members Insert Query

                        $member = Members::create([
                            'first_name' => $request->first_name,
                            'middle_name' => $request->middle_name,
                            'last_name' => $request->last_name,
                            'nickname' => $request->nickname,
                            'birthday' => $request->birthday,
                            'gender' => $request->gender,
                            'civil_status' => $request->civil_status,
                            'religion' => $request->religion,
                            'baptism' => $request->baptized,
                            'confirmation' => $request->confirmed,
                            'member_status_id' => 1,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Members Insert Query

                    // START: Address Insert Query

                        $address = Addresses::create([
                            'address_line1' => $request->member_addressLine1,
                            'address_line2' => $request->member_addressLine2,
                            'city' => $request->member_city,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Address Insert Query

                    // START: Contact Number Insert Query

                        $contactNumber = ContactNumbers::create([
                            'mobile' => $request->member_mobile,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Contact Number Insert Query

                    // START: Email Insert Query

                        $email = Emails::create([
                            'email' => $request->member_email,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Email Insert Query

                    // START: Occupation Insert Query

                        $occupation = Occupation::create([
                            'occupation_name' => $request->occupation,
                            'specialty' => $request->specialty,
                            'company' => $request->company,
                            'address_line1' => $request->company_addressLine1,
                            'address_line2' => $request->company_addressLine2,
                            'city' => $request->company_city,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Occupation Insert Query

                    // START: Contact Info Insert Query

                        $contactInfo = ContactInfo::create([
                            'member_id' => $member->member_id,
                            'address_id' => $address->id,
                            'contactNumber_id' => $contactNumber->id,
                            'email_id' => $email->id,
                            'occupation_id' => $occupation->id,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Contact Info Insert Query

                    // START: Singles Encounter Insert Query

                        $SE = SinglesEncounter::create([
                            'member_id' => $member->member_id,
                            'room' => $request->room,
                            'nation' => $request->nation,
                            'event_id' => $request->event_id,
                            'status' => $request->status,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Singles Encounter Insert Query

                    // START: Emergency Contact Insert Query

                        $dataSet = [];
                        $emergency_contacts = $request->emergency_contacts;

                        foreach ($emergency_contacts as $contacts) {
                            $dataSet[] = [
                                'seId' => $SE->seId,
                                'name' => $contacts['name'],
                                'mobile' => $contacts['mobile'],
                                'email' => $contacts['email'],
                                'relationship' => $contacts['relationship'],
                                'created_by' => $contacts['created_by'],
                                'created_on' => now()
                            ];
                        }

                        $emergencyContacts = DB::table('tblemergency_contacts')->insert($dataSet);

                    // END: Emergency Contact Insert Query

                    // START: Imvite Insert Query

                        $inviterDataSet = [];
                        $inviters = $request->inviter;

                        foreach ($inviters as $inviter) {
                            $inviterDataSet[] = [
                                'seId' => $SE->seId,
                                'name' => $inviter['name'],
                                'relationship' => $inviter['relationship'],
                                'created_by' => $inviter['created_by'],
                                'created_on' => now()
                            ];
                        }

                        $inviterData = DB::table('tblinvites')->insert($inviterDataSet);

                    // END: Invite Insert Query

                    if ($contactInfo->count() > 0 & $inviterData === true) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Adding participant was successful!'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 500,
                            'message' => 'A problem was encountered while adding participant records. Please acontact system administrators.'
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Server Error: Please contact system adminstrator.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SinglesEncounter $singlesEncounter)
    {
        if ($singlesEncounter->count() > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'body' => $singlesEncounter
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'message' => 'No records found.'
            ]);
        }
    }

    public function showSE (Request $request) {
        $participants = Members::select('tblmembers.member_id', 'tblsingles_encounter.seId', 'tblevents.event_id', 'tblevents.event_subtitle As event', 'tblmembers.first_name', 'tblmembers.middle_name',
                                        'tblmembers.last_name', 'tblmembers.nickname', 'tblmembers.gender',
                                        'tblmembers.birthday', 'tblmembers.civil_status', 'tblmembers.religion',
                                        'tblmembers.baptism', 'tblmembers.confirmation', 'tbladdresses.address_line1',
                                        'tbladdresses.address_line2', 'tbladdresses.city', 'tblcontact_numbers.mobile',
                                        'tblemails.email', 'tbloccupations.occupation_name', 'tbloccupations.specialty',
                                        'tbloccupations.company', 'tbloccupations.address_line1 As work_addressLine1',
                                        'tbloccupations.address_line2 as work_addressLine2', 'tbloccupations.city As work_city',
                                        'tblsingles_encounter.status As attendance_status')
                            ->leftJoin('tblcontact_infos', 'tblmembers.member_id', '=', 'tblcontact_infos.member_id')
                            ->leftJoin('tbladdresses', 'tblcontact_infos.address_id', '=', 'tbladdresses.address_id')
                            ->leftJoin('tblcontact_numbers', 'tblcontact_infos.contactNumber_id', '=', 'tblcontact_numbers.contactNumber_id')
                            ->leftJoin('tblemails', 'tblcontact_infos.email_id', '=', 'tblemails.email_id')
                            ->leftJoin('tbloccupations', 'tblcontact_infos.occupation_id', '=', 'tbloccupations.occupation_id')
                            ->leftJoin('tblsingles_encounter', 'tblmembers.member_id', '=', 'tblsingles_encounter.member_id')
                            ->leftJoin('tblevents', 'tblsingles_encounter.event_id', '=', 'tblevents.event_id')
                            ->where('tblmembers.civil_status', 'LIKE', '%single')
                            ->with(['SeEmergencyContacts' => function ($query) {
                                $query->select('tblemergency_contacts.emergencyContact_id',
                                    'tblemergency_contacts.name',
                                    'tblemergency_contacts.mobile',
                                    'tblemergency_contacts.email',
                                    'tblemergency_contacts.relationship');
                            }])
                            ->with(['SeInviters' => function ($query) {
                                $query->select('tblinvites.invite_id',
                                    'tblinvites.name',
                                    'tblinvites.relationship');
                            }])
                            ->with(['YeEmergencyContacts' => function ($query) {
                                $query->select('tblemergency_contacts.emergencyContact_id',
                                    'tblemergency_contacts.name',
                                    'tblemergency_contacts.mobile',
                                    'tblemergency_contacts.email',
                                    'tblemergency_contacts.relationship');
                            }])
                            ->with(['YeInviters' => function ($query) {
                                $query->select('tblinvites.invite_id',
                                    'tblinvites.name',
                                    'tblinvites.relationship');
                            }])
                            ->get();

        if ($participants->count() > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'body' => $participants
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'message' => 'No records found.'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SinglesEncounter $singlesEncounter)
    {
        //
    }

    // START: Update tblsingles_encounter and tblattendances

        public function createAttendance(Request $request) {
            try {
                $validator = Validator::make($request->all(), [
                    'member_id' => 'required|integer',
                    'event_id' => 'required|integer',
                    'status' => 'required|string|max:5',
                    'created_by' => 'nullable|integer'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 422,
                        'message' => $validator->messages(),
                    ]);
                } else {
                    $seAttendanceExist = SinglesEncounter::where('member_id', '=', $request->member_id)->first();

                    if ($seAttendanceExist) {
                        $seAttendance = SinglesEncounter::where('member_id', '=', $request->member_id)
                                ->update([
                                    'event_id' => $request->event_id,
                                    'status' => $request->status
                                ]);

                        if ($seAttendance) {
                            return response()->json([
                                'status' => 200,
                                'message' => 'Attendance updated successfully!'
                            ]);
                        } else{
                            return response()->json([
                                'status' => 422,
                                'message' => 'An error occured while updating the attendance. Please contact system administrator.'
                            ]);
                        }
                    } else {
                        $SE = SinglesEncounter::create([
                            'member_id' => $request->member_id,
                            'room' => $request->room,
                            'nation' => $request->nation,
                            'event_id' => $request->event_id,
                            'status' => $request->status,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                        if ($SE) {
                            return response()->json([
                                'status' => 200,
                                'message' => 'Attendance updated successfully!'
                            ]);
                        } else{
                            return response()->json([
                                'status' => 422,
                                'message' => 'An error occured while updating the attendance. Please contact system administrator.'
                            ]);
                        }
                    }


                    $existingAttendance = Attendance::where('member_id', '=', $request->member_id)->first();

                    if ($existingAttendance) {
                        $existingAttendance->update([
                            'event_id' => $request->event_id,
                            'status' => $request->status
                        ]);

                        if ($seAttendance > 0 & $existingAttendance->count() > 0) {
                            return response()->json([
                                'status' => 200,
                                'message' => 'Attendance updated successfully!'
                            ]);
                        } else{
                            return response()->json([
                                'status' => 422,
                                'message' => 'An error occured while updating the attendance. Please contact system administrator.'
                            ]);
                        }
                    } else{
                        $attendance = Attendance::create([
                            'member_id' => $request->member_id,
                            'event_id' => $request->event_id,
                            'status' => $request->status,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                        if ($seAttendance > 0 & $attendance->count() > 0) {
                            return response()->json([
                                'status' => 200,
                                'message' => 'Attendance updated successfully!'
                            ]);
                        } else{
                            return response()->json([
                                'status' => 422,
                                'message' => 'An error occured while updating the attendance. Please contact system administrator.'
                            ]);
                        }
                    }
                }

            } catch (\Throwable $th) {
                // return response()->json([
                //     'status' => 500,
                //     'message' => 'Server Error: Please contact system adminstrator.'
                // ]);
                throw $th;
            }
        }

    // END: Update tblsingles_encounter and tblattendances

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SinglesEncounter $singlesEncounter)
    {
        try {
            $validator = Validator::make($request->all(), [
                // START: Table Members Data

                    'member_id' => 'nullable|integer',
                    'first_name' => 'nullable|string|max:191',
                    'middle_name' => 'nullable|string|max:191',
                    'last_name' => 'nullable|string|max:191',
                    'nickname' => 'nullable|string|max:191',
                    'birthday' => 'nullable|string|max:191',
                    'gender' => 'nullable|string|max:90',
                    'civil_status' => 'nullable|string|max:50',
                    'religion' => 'nullable|string|max:191',
                    'baptized' => 'nullable|string|max:30',
                    'confirmed' => 'nullable|string|max:30',
                    'member_status_id' => 'nullable|integer',

                // END: Table Members Data

                // START: Table Address Data

                    'member_addressLine1' => 'nullable|string|max:255',
                    'member_addressLine2' => 'nullable|string|max:255',
                    'member_city' => 'nullable|string|max:255',

                // END: Table Address Data

                // START: Table ContactNumbers Data

                    'member_mobile' => 'nullable|string|max:20',

                // END: Table ContactNumbers Data

                // START: Table Emails Data

                    'member_email' => 'nullable|string|max:191',

                // END: Table Emails Data

                // Start: Table Occupations Data

                    'occupation' => 'nullable|string|max:191',
                    'specialty' => 'nullable|string|max:191',
                    'company' => 'nullable|string|max:191',
                    'company_addressLine1' => 'nullable|string|max:255',
                    'company_addressLine2' => 'nullable|string|max:255',
                    'city' => 'nullable|string|max:191',

                // END: Table Occupations Data

                // START: Table EmergencyContacts Data

                    'emergency_contacts' => 'nullable|array',

                // END: Table EmergencyContacts Data

                // START: Table Invite Data

                    'inviters' => 'nullable|array',

                // END: Table Invite Data

                // START: Table Singles Encounter Data

                    // 'event_id' => 'nullable|integer',

                // END: Table Singles Encounter Data

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages(),
                ]);
            } else {
                // START: Members Update Query
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
                            'religion' => $request->religion,
                            'baptism' => $request->baptized,
                            'confirmation' => $request->confirmed,
                            'member_status_id' => 1,
                        ]);

                // END: Members Update Query

                // START: Address Update Query

                    $address = Addresses::where('address_id', $getMember->address_id)
                        ->update([
                            'address_line1' => $request->member_addressLine1,
                            'address_line2' => $request->member_addressLine2,
                            'city' => $request->member_city,
                        ]);

                // END: Address Update Query

                // START: Contact Number Update Query

                    $contactNumber = ContactNumbers::where('contactNumber_id', $getMember->contactNumber_id)
                        ->update([
                            'mobile' => $request->member_mobile,
                        ]);

                // END: Contact Number Update Query

                // START: Email Update Query

                    $email = Emails::where('email_id', $getMember->email_id)
                        ->update([
                            'email' => $request->member_email,
                        ]);

                // END: Email Update Query

                // START: Occupation Update Query

                    $occupation = Occupation::where('occupation_id', $getMember->occupation_id)
                        ->update([
                        'occupation_name' => $request->occupation,
                        'specialty' => $request->specialty,
                        'company' => $request->company,
                        'address_line1' => $request->company_addressLine1,
                        'address_line2' => $request->company_addressLine2,
                        'city' => $request->city,
                    ]);

                // END: Occupation Update Query

                // START: Singles Encounter Update Query
                    $getSe = SinglesEncounter::where('member_id', $getMember->member_id)->first();
                    $dataSet = [];
                    $emergency_contacts = $request->emergency_contacts;

                    if ($getSe) {
                        if ($request->event_id) {
                            $SE = SinglesEncounter::where('seId', $getSe->seId)
                            ->update([
                                'event_id' => $request->event_id,
                            ]);
                        }

                        // START: Emergency Contacts Update
                            $getEmergencyContacts = EmergencyContact::where('seId', $getSe->seId)->get();

                            $existingContactIds  = \DB::table('tblemergency_contacts')
                                            ->where('seId', $getSe->seId)
                                            ->pluck('emergencyContact_id')
                                            ->toArray();

                            $contactIdsToDelete = array_diff($existingContactIds, array_column($emergency_contacts, 'emergencyContact_id'));

                            $deleteContact = \DB::table('tblemergency_contacts')
                                ->whereIn('emergencyContact_id', $contactIdsToDelete)
                                ->delete();

                            foreach ($emergency_contacts as $contact) {
                                if (isset($contact['emergencyContact_id'])) {
                                    if (in_array($contact['emergencyContact_id'], $existingContactIds))
                                        \DB::table('tblemergency_contacts')
                                            ->where('emergencyContact_id', $contact['emergencyContact_id'])
                                            ->update([
                                                'name' => $contact['name'],
                                                'mobile' => $contact['mobile'],
                                                'email' => $contact['email'],
                                                'relationship' => $contact['relationship']
                                            ]);
                                } else {
                                    \DB::table('tblemergency_contacts')->insert([
                                        'seId' => $getSe->seId,
                                        'name' => $contact['name'],
                                        'mobile' => $contact['mobile'],
                                        'email' => $contact['email'],
                                        'relationship' => $contact['relationship'],
                                        'created_by' => $request->created_by,
                                        'created_on' => now()
                                    ]);
                                }
                            }
                        // END: Emergency Contacts Update

                        // START: Inviter Update

                            $inviters = $request->inviters;
                            $getInviters = Invite::where('seId', $getSe->seId)->get();

                            $existingInviterIds = \DB::table('tblinvites')
                                                        ->where('seId', $getSe->seId)
                                                        ->pluck('invite_id')
                                                        ->toArray();

                            $inviterIdsToDelete = array_diff($existingInviterIds, array_column($inviters, 'invite_id'));

                            $deleteInviter = \DB::table('tblinvites')
                                                ->whereIn('invite_id', $inviterIdsToDelete)
                                                ->delete();

                            foreach ($inviters as $inviter) {
                                if (isset($inviter['invite_id'])) {
                                    if (in_array($inviter['invite_id'], $existingInviterIds))
                                        \DB::table('tblinvites')
                                            ->where('invite_id', $inviter['invite_id'])
                                            ->update([
                                                'name' => $inviter['name'],
                                                'relationship' => $inviter['relationship']
                                            ]);
                                } else {
                                    \DB::table('tblinvites')->insert([
                                        'seId' => $getSe->seId,
                                        'name' => $inviter['name'],
                                        'relationship' => $inviter['relationship'],
                                        'created_by' => $request->created_by,
                                        'created_on' => now()
                                    ]);
                                }
                            }

                        // END: Inviter Update

                            return response()->json([
                                'status' => 200,
                                'message' => 'Update Successful!'
                            ]);

                    } else {
                        $SE = SinglesEncounter::create([
                            'member_id' => $getMember->member_id,
                            'room' => $request->room,
                            'tribe' => $request->tribe,
                            'nation' => $request->nation,
                            'event_id' => $request->event_id,
                            'status' => $request->status,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);


                        // START: Emergency Contact Insert Query

                            $dataSet = [];
                            $emergency_contacts = $request->emergency_contacts;

                            foreach ($emergency_contacts as $contacts) {
                                $dataSet[] = [
                                    'seId' => $SE->seId,
                                    'name' => $contacts['name'],
                                    'mobile' => $contacts['mobile'],
                                    'email' => $contacts['email'],
                                    'relationship' => $contacts['relationship'],
                                    'created_by' => $request->created_by,
                                    'created_on' => now()
                                ];
                            }

                            $emergencyContacts = DB::table('tblemergency_contacts')->insert($dataSet);

                        // END: Emergency Contact Insert Query

                        if ($emergencyContacts === true) {
                            return response()->json([
                                'status' => 200,
                                'message' => 'Update Success!'
                            ]);
                        } else {
                            return response()->json([
                                'status' => 500,
                                'message' => 'A problem was encountered while updating participant records. Please acontact system administrators.'
                            ]);
                        }
                    }
            }
        } catch (\Throwable $th) {
            // return response()->json([
            //     'status' => 500,
            //     'message' => 'Server Error: Please contact system adminstrator.'
            // ]);
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SinglesEncounter $singlesEncounter)
    {
        //
    }
}
