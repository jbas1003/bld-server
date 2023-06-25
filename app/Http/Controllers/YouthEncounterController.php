<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;
use App\Models\YouthEncounter;
use App\Http\Controllers\Controller;

class YouthEncounterController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(YouthEncounter $youthEncounter)
    {
        //
    }

    public function showYE(Request $request) {
        $participants = Members::select('tblmembers.member_id', 'tblyouth_encounter.yeId', 'tblmembers.first_name', 'tblmembers.middle_name',
                                        'tblmembers.last_name', 'tblmembers.nickname', 'tblmembers.gender',
                                        'tblmembers.birthday', 'tblmembers.civil_status', 'tblmembers.religion',
                                        'tblmembers.baptism', 'tblmembers.confirmation', 'tbladdresses.address_line1',
                                        'tbladdresses.address_line2', 'tbladdresses.city', 'tblcontact_numbers.mobile',
                                        'tblemails.email', 'tbloccupations.occupation_name', 'tbloccupations.specialty',
                                        'tbloccupations.company', 'tbloccupations.address_line1 As work_addressLine1',
                                        'tbloccupations.address_line2 as work_addressLine2', 'tbloccupations.city As work_city',
                                        'tblyouth_encounter.status As attendance_status')
                            ->leftJoin('tblcontact_infos', 'tblmembers.member_id', '=', 'tblcontact_infos.member_id')
                            ->leftJoin('tbladdresses', 'tblcontact_infos.address_id', '=', 'tbladdresses.address_id')
                            ->leftJoin('tblcontact_numbers', 'tblcontact_infos.contactNumber_id', '=', 'tblcontact_numbers.contactNumber_id')
                            ->leftJoin('tblemails', 'tblcontact_infos.email_id', '=', 'tblemails.email_id')
                            ->leftJoin('tbloccupations', 'tblcontact_infos.occupation_id', '=', 'tbloccupations.occupation_id')
                            ->leftJoin('tblyouth_encounter', 'tblmembers.member_id', '=', 'tblyouth_encounter.member_id')
                            ->where('tblmembers.civil_status', 'LIKE', '%single')
                            ->with(['emergency_contacts' => function($query) {
                                $query->select('tblemergency_contacts.emergencyContact_id',
                                                'tblemergency_contacts.name',
                                                'tblemergency_contacts.mobile',
                                                'tblemergency_contacts.email',
                                                'tblemergency_contacts.relationship');
                            }])
                            ->with(['inviters' => function($query) {
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
    public function edit(YouthEncounter $youthEncounter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YouthEncounter $youthEncounter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YouthEncounter $youthEncounter)
    {
        //
    }
}
