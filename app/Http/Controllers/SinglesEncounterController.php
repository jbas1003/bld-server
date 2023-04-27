<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmergencyContact;
use App\Models\SinglesEncounter;
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
                // // START: Table Members Data

                //     'first_name' => 'required|string|max:191',
                //     'middle_name' => 'required|string|max:191',
                //     'last_name' => 'required|string|max:191',
                //     'nickname' => 'nullable|string|max:191',
                //     'birthday' => 'nullable|string|max:191',
                //     'gender' => 'nullable|string|max:90',
                //     'civil_status' => 'nullable|string|max:50',
                //     'religion' => 'nullable|string|max:191',
                //     'baptism' => 'nullable|string|max:30',
                //     'confirmation' => 'nullable|string|max:30',
                //     'member_status' => 'nullable|integer',
                //     'created_by' => 'required|integer',

                // // END: Table Members Data

                // // START: Table Address Data

                //     'member_addressLine1' => 'nullable|string|max:255',
                //     'member_addressLine2' => 'nullable|string|max:255',
                //     'member_city' => 'nullalbe|string|max:255',

                // // END: Table Address Data

                // // START: Table ContactNumbers Data

                //     'member_mobile' => 'nullable|string|max:20',

                // // END: Table ContactNumbers Data

                // // START: Table Emails Data

                //     'member_email' => 'nullable|string|max:191',

                // // END: Table Emails Data

                // // Start: Table Occupations Data

                //     'occupation' => 'nullable|string|max:191',
                //     'specialty' => 'nullable|string|max:191',
                //     'company' => 'nullable|string|max:191',
                //     'company_addressLine1' => 'nullable|string|max:255',
                //     'company_addressLine2' => 'nullable|string|max:255',
                //     'city' => 'nullable|string|max:191',

                // // END: Table Occupations Data

                // START: Table EmergencyContacts Data

                    'emergency_contacts' => 'nullable|array'

                // END: Table EmergencyContacts Data

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->message(),
                ]);
            } else {
                // $emergecnyContact = EmergencyContact::create([

                // ]);
                $emergency_contacts = $request->emergency_contacts;
                
                return $emergency_contacts->name;
                // for ($i=0; $i < count($emergency_contacts)-1; $i++) { 
                //     return $emergency_contacts[i]->name;
                // }
            }
        } catch (\Throwable $th) {
            throw $th;
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SinglesEncounter $singlesEncounter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SinglesEncounter $singlesEncounter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SinglesEncounter $singlesEncounter)
    {
        //
    }
}
