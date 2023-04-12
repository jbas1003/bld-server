<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\MemberStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MemberStatusController extends Controller
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
                'status' => 'required|string|max:191',
                'created_by' => 'required|integer',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $request->message()
                ], 422);
            } else {
                $ifExist = MemberStatus::where('status', Str::lower($request->status));
    
                if ($ifExist) {
                    return response()->json([
                        'status' => 422,
                        'errors' => 'Record already exist.'
                    ], 422);
                } else {
                    $memberStatus = MemberStatus::create([
                        'status' => $request->status,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);
    
                    if ($memberStatus) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Record successfully created!'
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
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberStatus $memberStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberStatus $memberStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MemberStatus $memberStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberStatus $memberStatus)
    {
        //
    }
}
