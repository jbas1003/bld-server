<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\EventType;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function attendanceList(Attendance $attendance, Request $request) {
        try {
            $eventCategory = EventType::where('event_type_name', $request->event_category)
                ->select('event_type_id')
                ->first();

            $eventType = EventType::where('event_type_category', $eventCategory->event_type_id)
                ->select('event_type_id')
                ->first();

            $attendance = Attendance::join('tblmembers', 'tblattendances.member_id', '=', 'tblmembers.member_id')
                                    ->join('tblevents', 'tblattendances.event_id', '=', 'tblevents.event_id')
                                    ->where('tblevents.event_type_id', $eventType->event_type_id)
                                    ->when($request->event_date, function($attendance) use ($request){
                                        $attendance->where('tblevents.start_date', $request->event_date);
                                    })
                                    ->when($request->event_id, function($attendance) use ($request){
                                        $attendance->where('tblevents.event_id', $request->event_id);                                    })
                                    ->select('tblmembers.first_name', 'tblmembers.middle_name', 'tblmembers.last_name',
                                            'tblmembers.birthday', 'tblmembers.gender', 'tblmembers.civil_status', 'tblattendances.status',
                                            'tblevents.event_subtitle', 'tblevents.start_date', 'tblevents.event_id')
                                    ->get();

            if ($attendance->count() > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success!',
                    'body' => $attendance
                ]);
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => 'No records Found.'
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function showAttendance(Attendance $attendance, Request $request) {
        try {
            $eventId = $request->event_id;
            $getAttendance = Members::leftjoin('tblcontact_infos', 'tblmembers.member_id', '=', 'tblcontact_infos.member_id')
                                    ->leftjoin('tbladdresses', 'tblcontact_infos.address_id', '=', 'tbladdresses.address_id')
                                    ->leftjoin('tblcontact_numbers', 'tblcontact_infos.contactNumber_id', '=', 'tblcontact_numbers.contactNumber_id')
                                    ->leftjoin('tblemails', 'tblcontact_infos.email_id', '=', 'tblemails.email_id')
                                    ->leftjoin('tbloccupations', 'tblcontact_infos.occupation_id', '=', 'tbloccupations.occupation_id')
                                    ->leftjoin('tblattendances', function($join) use ($eventId) {
                                        $join->on('tblmembers.member_id', '=', 'tblattendances.member_id')
                                        ->where('tblattendances.event_id', '=', $eventId);
                                    })
                                    ->select('tblmembers.member_id', 'tblmembers.first_name', 'tblmembers.middle_name', 'tblmembers.last_name', 'tblmembers.nickname',
                                    'tblcontact_numbers.mobile', 'tblemails.email', 'tblmembers.birthday', 'tblmembers.gender', 'tblmembers.civil_status',
                                    'tblmembers.religion', 'tblmembers.baptism', 'tblmembers.confirmation', 'tbladdresses.address_line1', 'tbladdresses.address_line2', 'tbladdresses.city',
                                     'tbloccupations.occupation_name', 'tbloccupations.specialty', 'tbloccupations.company', 'tbloccupations.address_line1 As work_address_line1',
                                    'tbloccupations.address_line2 As work_address_line2', 'tbloccupations.city As work_city',
                                    DB::raw('IFNULL(tblattendances.status, "") As status'), DB::raw('IFNULL(tblattendances.attendance_id, "") As attendance_id'))
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
    public function destroy(Request $request)
    {
        try {
            $attendance = Attendance::find($request->attendance_id);

            if ($attendance) {
                $attendance->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Attendance reset successful!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => 'Attendance reset unsuccessful. A problem was encountered while trying to reset attedance. Please contact system administrator.'
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
