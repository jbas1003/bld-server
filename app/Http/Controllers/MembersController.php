<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                'baptism' => 'required|string|max:191',
                'confirmation' => 'required|string|max:191',
                'occupation' => 'required|string|max:191',
                'specialty' => 'required|string|max:191',
                'company' => 'required|string|max:191',
                'company_address' => 'required|string|max:191',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->message(),
                ], 422);
            } else {
                $member = Members::create([
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'first_name' => $request->first_name,
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        // END: Add Members
    }

    /**
     * Display the specified resource.
     */
    public function show(Members $members)
    {
        //
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
    public function update(Request $request, Members $members)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Members $members)
    {
        //
    }
}
