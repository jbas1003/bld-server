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
                    'errors' => $request->messages()
                ], 422);
            } else {
                $ifExist = MemberStatus::where('status', '=', Str::lower($request->status))->get();
                
                if ($ifExist->count() > 0) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Record already exist.'
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
                            'status' => 422,
                            'message' => 'Server Error.'
                        ], 422);
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
        try {
            if ($memberStatus->count() > 0) {
                $status = MemberStatus::all();
                return response()->json([
                    'status' => 200,
                    'body' => $status
                ]);
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => 'No records found.'
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
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
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|string|max:191',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ], 422);
            } else {
                $updateStatus = MemberStatus::find($request->memberStatus_id);
                
                if (!$updateStatus) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'No record found.'
                    ], 422);
                } else {
                    $updateStatus->update([
                        'status' => $request->status
                    ]);
    
                    if ($memberStatus) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Record successfully updated!'
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 422,
                            'message' => 'Server Error.'
                        ], 422);
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberStatus $memberStatus, Request $request)
    {
        try {
            $delStatus = MemberStatus::find($request->memberStatus_id)
                        ->delete();

            if($delStatus) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Record was deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => 'A problem was encountered while deleting the record. Please contact system administrator.'
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
