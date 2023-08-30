<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Members;
use App\Models\Children;
use App\Models\Addresses;
use App\Models\Attendance;
use App\Models\Occupation;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use App\Models\ContactNumbers;
use App\Models\EmergencyContact;
use App\Models\MarriageEncounter;
use Illuminate\Support\Facades\DB;
use App\Models\MemberRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MarriageEncounterController extends Controller
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
                // Start: Husband Data

                    // START: Table Members Data

                        'husband_first_name' => 'nullable|string|max:191',
                        'husband_middle_name' => 'nullable|string|max:191',
                        'husband_last_name' => 'nullable|string|max:191',
                        'husband_nickname' => 'nullable|string|max:191',
                        'husband_birthday' => 'nullable|string|max:191',
                        'husband_gender' => 'nullable|string|max:90',
                        'husband_spouse' => 'nullable|string|max:100',
                        'husband_civil_status' => 'nullable|string|max:50',
                        'husband_religion' => 'nullable|string|max:191',
                        'husband_baptized' => 'nullable|string|max:30',
                        'husband_confirmed' => 'nullable|string|max:30',
                        'husband_status_id' => 'nullable|integer',
                        'created_by' => 'required|integer',

                    // END: Table Members Data

                    // START: Table Address Data

                        'husband_addressLine1' => 'nullable|string|max:255',
                        'husband_addressLine2' => 'nullable|string|max:255',
                        'husband_city' => 'nullable|string|max:255',

                    // END: Table Address Data

                    // START: Table ContactNumbers Data

                        'husband_mobile' => 'nullable|string|max:20',

                    // END: Table ContactNumbers Data

                    // START: Table Emails Data

                        'husband_email' => 'nullable|string|max:191',

                    // END: Table Emails Data

                    // Start: Table Occupations Data

                        'husband_occupation' => 'nullable|string|max:191',
                        'husband_specialty' => 'nullable|string|max:191',
                        'husband_company' => 'nullable|string|max:191',
                        'husband_company_addressLine1' => 'nullable|string|max:255',
                        'husband_company_addressLine2' => 'nullable|string|max:255',
                        'husband_company_city' => 'nullable|string|max:191',

                    // END: Table Occupations Data

                // END: Husband Data

                // Start: Wife Data

                    // START: Table Members Data

                    'wife_first_name' => 'nullable|string|max:191',
                    'wife_middle_name' => 'nullable|string|max:191',
                    'wife_last_name' => 'nullable|string|max:191',
                    'wife_nickname' => 'nullable|string|max:191',
                    'wife_birthday' => 'nullable|string|max:191',
                    'wife_gender' => 'nullable|string|max:90',
                    'wife_spouse' => 'nullable|string|max:100',
                    'wife_civil_status' => 'nullable|string|max:50',
                    'wife_religion' => 'nullable|string|max:191',
                    'wife_baptized' => 'nullable|string|max:30',
                    'wife_confirmed' => 'nullable|string|max:30',
                    'wife_status_id' => 'nullable|integer',
                    'created_by' => 'required|integer',

                // END: Table Members Data

                // START: Table Address Data

                    'wife_addressLine1' => 'nullable|string|max:255',
                    'wife_addressLine2' => 'nullable|string|max:255',
                    'wife_city' => 'nullable|string|max:255',

                // END: Table Address Data

                // START: Table ContactNumbers Data

                    'wife_mobile' => 'nullable|string|max:20',

                // END: Table ContactNumbers Data

                // START: Table Emails Data

                    'wife_email' => 'nullable|string|max:191',

                // END: Table Emails Data

                // Start: Table Occupations Data

                    'wife_occupation' => 'nullable|string|max:191',
                    'wife_specialty' => 'nullable|string|max:191',
                    'wife_company' => 'nullable|string|max:191',
                    'wife_company_addressLine1' => 'nullable|string|max:255',
                    'wife_company_addressLine2' => 'nullable|string|max:255',
                    'wife_company_city' => 'nullable|string|max:191',

                // END: Table Occupations Data

            // END: Wife Data

                // START: Table EmergencyContacts Data

                    'children' => 'nullable|array',

                // END: Table EmergencyContacts Data

                // START: Table Invite Data

                    'inviter' => 'nullable|array',

                // END: Table Invite Data

                // START: Table Marriage Encounter Data

                    'room' => 'nullable|string|max:50',

                // END: Table Marriage Encounter Data

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages(),
                ]);
            } else {
                $husbandExist = ContactInfo::join('tblmembers', 'tblcontact_infos.member_id', '=', 'tblmembers.member_id')
                                          ->join('tbladdresses', 'tblcontact_infos.address_id', '=', 'tbladdresses.address_id')
                                          ->join('tblcontact_numbers', 'tblcontact_infos.contactNumber_id', '=', 'tblcontact_numbers.contactNumber_id')
                                          ->join('tblemails', 'tblcontact_infos.email_id', '=', 'tblemails.email_id')
                                          ->first();

                if ((($husbandExist->first_name === $request->husband_first_name) && ($husbandExist->middle_name === $request->husband_middle_name) && ($husbandExist->last_name === $request->husband_last_name))) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Please check name, email, or mobile number. One of these info might already exist, or might have not existed.'
                ], 422);
                } else {
                    // Start: Husband Insert Queries

                        // START: Members Insert Query

                            $husband = Members::create([
                                'first_name' => $request->husband_first_name,
                                'middle_name' => $request->husband_middle_name,
                                'last_name' => $request->husband_last_name,
                                'nickname' => $request->husband_nickname,
                                'birthday' => $request->husband_birthday,
                                'gender' => $request->husband_gender,
                                'civil_status' => $request->husband_civil_status,
                                'religion' => $request->husband_religion,
                                'baptism' => $request->baphusband_baptizedtized,
                                'confirmation' => $request->husband_confirmed,
                                'member_status_id' => 1,
                                'created_by' => $request->created_by,
                                'created_on' => now()
                            ]);

                        // END: Members Insert Query

                        // START: Address Insert Query

                            $husband_address = Addresses::create([
                                'address_line1' => $request->husband_addressLine1,
                                'address_line2' => $request->husband_addressLine2,
                                'city' => $request->husband_city,
                                'created_by' => $request->created_by,
                                'created_on' => now()
                            ]);

                        // END: Address Insert Query

                        // START: Contact Number Insert Query

                            $husband_contactNumber = ContactNumbers::create([
                                'mobile' => $request->husband_mobile,
                                'created_by' => $request->created_by,
                                'created_on' => now()
                            ]);

                        // END: Contact Number Insert Query

                        // START: Email Insert Query

                            $husband_email = Emails::create([
                                'email' => $request->husband_email,
                                'created_by' => $request->created_by,
                                'created_on' => now()
                            ]);

                        // END: Email Insert Query

                        // START: Occupation Insert Query

                            $husband_occupation = Occupation::create([
                                'occupation_name' => $request->husband_occupation,
                                'specialty' => $request->husband_specialty,
                                'company' => $request->husband_company,
                                'address_line1' => $request->husband_company_addressLine1,
                                'address_line2' => $request->husband_company_addressLine2,
                                'city' => $request->husband_company_city,
                                'created_by' => $request->created_by,
                                'created_on' => now()
                            ]);

                        // END: Occupation Insert Query

                        // START: Contact Info Insert Query

                            $husband_contactInfo = ContactInfo::create([
                                'member_id' => $husband->member_id,
                                'address_id' => $husband_address->id,
                                'contactNumber_id' => $husband_contactNumber->id,
                                'email_id' => $husband_email->id,
                                'occupation_id' => $husband_occupation->id,
                                'created_by' => $request->created_by,
                                'created_on' => now()
                            ]);

                        // END: Contact Info Insert Query

                        // START: Marriage Encounter Insert Query

                            $husband_ME = MarriageEncounter::create([
                                'member_id' => $husband->member_id,
                                'room' => $request->room,
                                'event_id' => $request->event_id,
                                'status' => $request->status,
                                'created_by' => $request->created_by,
                                'created_on' => now()
                            ]);

                        // END: Marriage Encounter Insert Query

                        // START: Invite Insert Query

                        $husband_inviterDataSet = [];
                        $husband_inviters = $request->inviter;

                        foreach ($husband_inviters as $inviter) {
                            $husband_inviterDataSet[] = [
                                'meId' => $husband_ME->meId,
                                'name' => $inviter['name'],
                                'relationship' => $inviter['relationship'],
                                'created_by' => $inviter['created_by'],
                                'created_on' => now()
                            ];
                        }

                        $husband_inviterData = DB::table('tblinvites')->insert($husband_inviterDataSet);

                    // END: Invite Insert Query

                    // END: Husband Insert Queries

                    // Start: Wife Insert Queries

                        // START: Members Insert Query

                        $wife = Members::create([
                            'first_name' => $request->wife_first_name,
                            'middle_name' => $request->wife_middle_name,
                            'last_name' => $request->wife_last_name,
                            'nickname' => $request->wife_nickname,
                            'birthday' => $request->wife_birthday,
                            'gender' => $request->wife_gender,
                            'civil_status' => $request->wife_civil_status,
                            'religion' => $request->wife_religion,
                            'baptism' => $request->bapwife_baptizedtized,
                            'confirmation' => $request->wife_confirmed,
                            'member_status_id' => 1,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Members Insert Query

                    // START: Address Insert Query

                        $wife_address = Addresses::create([
                            'address_line1' => $request->wife_addressLine1,
                            'address_line2' => $request->wife_addressLine2,
                            'city' => $request->wife_city,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Address Insert Query

                    // START: Contact Number Insert Query

                        $wife_contactNumber = ContactNumbers::create([
                            'mobile' => $request->wife_mobile,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Contact Number Insert Query

                    // START: Email Insert Query

                        $wife_email = Emails::create([
                            'email' => $request->wife_email,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Email Insert Query

                    // START: Occupation Insert Query

                        $wife_occupation = Occupation::create([
                            'occupation_name' => $request->wife_occupation,
                            'specialty' => $request->wife_specialty,
                            'company' => $request->wife_company,
                            'address_line1' => $request->wife_company_addressLine1,
                            'address_line2' => $request->wife_company_addressLine2,
                            'city' => $request->wife_company_city,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Occupation Insert Query

                    // START: Contact Info Insert Query

                        $wife_contactInfo = ContactInfo::create([
                            'member_id' => $wife->member_id,
                            'address_id' => $wife_address->id,
                            'contactNumber_id' => $wife_contactNumber->id,
                            'email_id' => $wife_email->id,
                            'occupation_id' => $wife_occupation->id,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Contact Info Insert Query

                    // START: Marriage Encounter Insert Query

                        $wife_ME = MarriageEncounter::create([
                            'member_id' => $wife->member_id,
                            'room' => $request->room,
                            'event_id' => $request->event_id,
                            'status' => $request->status,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                    // END: Marriage Encounter Insert Query

                    // START: Invite Insert Query

                        $wife_inviterDataSet = [];
                        $wife_inviters = $request->inviter;

                        foreach ($wife_inviters as $inviter) {
                            $wife_inviterDataSet[] = [
                                'meId' => $wife_ME->meId,
                                'name' => $inviter['name'],
                                'relationship' => $inviter['relationship'],
                                'created_by' => $inviter['created_by'],
                                'created_on' => now()
                            ];
                        }

                        $wife_inviterData = DB::table('tblinvites')->insert($wife_inviterDataSet);

                    // END: Invite Insert Query

                // END: Wife Insert Queries

                // START: Husband-Wife Relationship

                        $husband_wife = [
                            'member_id' => $husband->member_id,
                            'relative_id' => $wife->member_id,
                            'relationship_id' => 2,
                            'created_by' => $request->created_by
                        ];

                        $husbandWife = DB::table('tblmember_relationships')->insert($husband_wife);

                        $wife_husband = [
                            'member_id' => $wife->member_id,
                            'relative_id' => $husband->member_id,
                            'relationship_id' => 1,
                            'created_by' => $request->created_by
                        ];

                        $wifeHusband = DB::table('tblmember_relationships')->insert($wife_husband);

                // END: Husband-Wife Relationship

                // START: Child Insert Query
                    $husband_dataSet = [];
                    $wife_dataSet = [];
                    $dataSet = [];
                    $children = $request->children;

                    $idSet = [];

                    $addressData_Set = [];
                    $address_data = [];

                    $mobile_dataSet = [];
                    $mobile_data = [];

                    $email_dataSet = [];
                    $email_data = [];

                    $occupations_dataSet = [];
                    $occupations_data = [];

                    $contact_info_dataSet = [];

                    foreach ($children as $child) {
                        $dataSet['member_id'] = DB::table('tblmembers')->insertGetId([
                            'first_name' => $child['firstName'],
                            'middle_name' => $child['middleName'],
                            'last_name' => $child['lastName'],
                            'birthday' => $child['birthday'],
                            'created_by' => $child['created_by'],
                            'created_on' => now()
                        ]);

                        $idSet[] = $dataSet;
                    }

                    foreach ($idSet as $id) {


                        $addressData_Set['address_id'] = DB::table('tbladdresses')->insertGetId([
                            'address_line1' => null,
                            'address_line2' => null,
                            'city' => null,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                        // $address_data[] = $addressData_Set;

                        $mobile_dataSet['contactNumber_id'] = DB::table('tblcontact_numbers')->insertGetId([
                            'mobile' => null,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                        // $mobile_data[] = $mobile_dataSet;

                        $email_dataSet['email_id'] = DB::table('tblemails')->insertGetId([
                            'email' => null,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);

                        // $email_data[] = $email_dataSet;

                        $occupations_dataSet['occupation_id'] = DB::table('tbloccupations')->insertGetId([
                            'occupation_name' => null,
                            'specialty' => null,
                            'company' => null,
                            'address_line1' => null,
                            'address_line2' => null,
                            'city' => null,
                            'created_by' => $request->created_by,
                            'created_on' => now(),
                        ]);

                        // $occupations_data[] = $occupations_dataSet;

                        $contact_info_dataSet = ContactInfo::create([
                            'member_id' => $id['member_id'],
                            'address_id' => $addressData_Set['address_id'],
                            'contactNumber_id' => $mobile_dataSet['contactNumber_id'],
                            'email_id' => $email_dataSet['email_id'],
                            'occupation_id' => $occupations_dataSet['occupation_id'],
                            'created_by' => $request->created_by,
                            'created_on' => now(),
                        ]);

                        $husband_dataSet = [
                            'member_id' => $husband->member_id,
                            'relative_id' => $id['member_id'],
                            'relationship_id' => 5,
                            'created_by' => $request->created_by
                        ];
                        $husband_children = DB::table('tblmember_relationships')->insert($husband_dataSet);

                        $wife_dataSet = [
                            'member_id' => $wife->member_id,
                            'relative_id' => $id['member_id'],
                            'relationship_id' => 5,
                            'created_by' => $request->created_by
                        ];
                        $wife_children = DB::table('tblmember_relationships')->insert($wife_dataSet);
                    }
                }
            }
        } catch (\Throwable $th) {
            // return response()->json([
            //     'status' => 500,
            //     'message' => 'Server Error: Please contact system adminstrator.'
            // ]);

            return $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MarriageEncounter $marriageEncounter)
    {
        if ($marriageEncounter->count() > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'body' => $marriageEncounter
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'message' => 'No records found.'
            ]);
        }
    }

    public function showME (Request $request) {
        $participants = Members::select('tblmembers.member_id', 'tblmarriage_encounter.meId', 'tblmembers.first_name', 'tblmembers.middle_name',
                                        'tblmembers.last_name', 'tblmembers.nickname', 'tblmembers.gender',
                                        'tblmembers.birthday', 'tblmembers.civil_status', 'tblmembers.spouse', 'tblmembers.religion',
                                        'tblmembers.baptism', 'tblmembers.confirmation', 'tbladdresses.address_line1',
                                        'tbladdresses.address_line2', 'tbladdresses.city', 'tblcontact_numbers.mobile',
                                        'tblemails.email', 'tbloccupations.occupation_name', 'tbloccupations.specialty',
                                        'tbloccupations.company', 'tbloccupations.address_line1 As work_addressLine1',
                                        'tbloccupations.address_line2 as work_addressLine2', 'tbloccupations.city As work_city',
                                        'tblmarriage_encounter.status As attendance_status')
                            ->leftJoin('tblcontact_infos', 'tblmembers.member_id', '=', 'tblcontact_infos.member_id')
                            ->leftJoin('tbladdresses', 'tblcontact_infos.address_id', '=', 'tbladdresses.address_id')
                            ->leftJoin('tblcontact_numbers', 'tblcontact_infos.contactNumber_id', '=', 'tblcontact_numbers.contactNumber_id')
                            ->leftJoin('tblemails', 'tblcontact_infos.email_id', '=', 'tblemails.email_id')
                            ->leftJoin('tbloccupations', 'tblcontact_infos.occupation_id', '=', 'tbloccupations.occupation_id')
                            ->leftJoin('tblmarriage_encounter', 'tblmembers.member_id', '=', 'tblmarriage_encounter.member_id')
                            ->where('tblmembers.civil_status', 'LIKE', '%Married')
                            ->orWhere('tblmembers.civil_status', null)
                            ->with(['Relationships' => function ($query) {
                                $query->select('tblmember_relationships.relative_id', 'relatives.first_name', 'relatives.middle_name', 'relatives.last_name', 'tblrelationships.relationship')
                                      ->join('tblrelationships', 'tblmember_relationships.relationship_id', '=', 'tblrelationships.relationship_id')
                                      ->join('tblmembers AS relatives', 'tblmember_relationships.relative_id', '=', 'relatives.member_id');
                            }])
                            ->with(['MeInviters' => function ($query) {
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
    public function edit(MarriageEncounter $marriageEncounter)
    {
        //
    }

    // START: Update tblmarriage_encounter and tblattendances

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
                $seAttendance = MarriageEncounter::where('member_id', '=', $request->member_id)
                            ->update([
                                'event_id' => $request->event_id,
                                'status' => $request->status
                            ]);

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

                return $seAttendance;
            }

        } catch (\Throwable $th) {
            // return response()->json([
            //     'status' => 500,
            //     'message' => 'Server Error: Please contact system adminstrator.'
            // ]);
            throw $th;
        }
    }

// END: Update tblmarriage_encounter and tblattendances

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarriageEncounter $marriageEncounter)
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

                    'children' => 'nullable|array',

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

                // START: Marriage Encounter Update Query
                    $getMe = MarriageEncounter::where('member_id', $getMember->member_id)->first();
                    $dataSet = [];
                    $emergency_contacts = $request->emergency_contacts;

                    if ($getMe) {
                        if ($request->event_id) {
                            $ME = MarriageEncounter::where('meId', $getMe->meId)
                            ->update([
                                'event_id' => $request->event_id,
                            ]);
                        }

                        // START: Emergency Contacts Update
                            $getChildren = Children::where('meId', $getMe->meId)->get();

                            $existingContactIds  = DB::table('tblchildren')
                                            ->where('meId', $getMe->meId)
                                            ->pluck('child_id')
                                            ->toArray();

                            $contactIdsToDelete = array_diff($existingContactIds, array_column($emergency_contacts, 'child_id'));

                            $deleteContact = \DB::table('tblchildren')
                                ->whereIn('child_id', $contactIdsToDelete)
                                ->delete();

                            foreach ($emergency_contacts as $contact) {
                                if (isset($contact['child_id'])) {
                                    if (in_array($contact['child_id'], $existingContactIds))
                                        \DB::table('tblchildren')
                                            ->where('child_id', $contact['child_id'])
                                            ->update([
                                                'first_name' => $contact['first_name'],
                                                'middle_name' => $contact['middle_name'],
                                                'last_name' => $contact['last_name'],
                                                'age' => $contact['age']
                                            ]);
                                } else {
                                    \DB::table('tblchildren')->insert([
                                        'meId' => $getMe->meId,
                                        'first_name' => $contact['first_name'],
                                        'middle_name' => $contact['middle_name'],
                                        'last_name' => $contact['last_name'],
                                        'age' => $contact['age'],
                                        'created_by' => $request->created_by,
                                        'created_on' => now()
                                    ]);
                                }
                            }
                        // END: Emergency Contacts Update

                        // START: Inviter Update

                            $inviters = $request->inviters;
                            $getInviters = Invite::where('meId', $getMe->meId)->get();

                            $existingInviterIds = \DB::table('tblinvites')
                                                        ->where('meId', $getMe->meId)
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
                                        'meId' => $getMe->meId,
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
                        $ME = MarriageEncounter::create([
                            'member_id' => $getMember->member_id,
                            'room' => $request->room,
                            'event_id' => $request->event_id,
                            'status' => $request->status,
                            'created_by' => $request->created_by,
                            'created_on' => now()
                        ]);


                        // START: Emergency Contact Insert Query

                            $dataSet = [];
                            $children = $request->children;

                            foreach ($children as $child) {
                                $dataSet[] = [
                                    'meId' => $ME->meId,
                                    'first_name' => $child['first_name'],
                                    'middle_name' => $child['middle_name'],
                                    'last_name' => $child['last_name'],
                                    'age' => $child['age'],
                                    'created_by' => $request->created_by,
                                    'created_on' => now()
                                ];
                            }

                            $ME_children = DB::table('tblchildren')->insert($dataSet);

                        // END: Emergency Contact Insert Query

                        if ($ME_children === true) {
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
    public function destroy(MarriageEncounter $marriageEncounter)
    {
        //
    }
}
