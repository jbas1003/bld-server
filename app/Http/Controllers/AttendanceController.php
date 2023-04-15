<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
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
            $validator = Validator::make($request->all(),[
                'member_id' => 'required|integer',
                'event_id' => 'required|integer',
                'status' => 'nullable|string',
                'created_by' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages()
                ]);
            } else {
                $memberExist = Attendance::where('member_id', $request->member_id)
                                        ->where('event_id', $request->event_id)
                                        ->where('status', $request->status)
                                        ->get();

                if ($memberExist->count() > 0) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'This person already has an attendance record for this event.'
                    ]);
                } else {
                    
                    $attendance = Attendance::create([
                        'member_id' => $request->member_id,
                        'event_id' => $request->event_id,
                        'status' => $request->status,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);

                    if ($attendance) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Attendance record added successfully!'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 422,
                            'message' => 'A problem was encountered while creating attendance record. Please contact system administrator.'
                        ]);
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
    public function show(Request $request)
    {
        // 
    }

    public function showAttendance(Request $request) {
        try {
            // $getAttendance = Attendance::join('tblmembers', 'tblattendances.member_id', '=', 'tblmembers.member_id')
            //                 ->join('tblevents', 'tblattendances.event_id', '=', 'tblevents.event_id')
            //                 ->select('tblattendances.attendance_id', 'tblattendances.member_id', 'tblattendances.event_id',
            //                         'tblattendances.status', 'tblevents.event_type_id')
            //                 ->get();

            $getAttendance = Attendance::where('tblattendances.event_id', $request->event_id)
                            ->join('tblevents', 'tblattendances.event_id', '=', 'tblevents.event_id')
                            ->select('tblattendances.attendance_id', 'tblattendances.member_id', 'tblattendances.event_id',
                                    'tblattendances.status', 'tblevents.event_type_id')
                            ->get();
            
            if ($getAttendance->count() > 0) {
                return response()->json([
                    'status' => 200,
                    'body' => $getAttendance
                ], 200);
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => 'No attendance records yet.'
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
