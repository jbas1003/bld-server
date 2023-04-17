<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
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
                'event_name' => 'required|string|max:200',
                'event_subtitle' => 'nullable|string|max:200',
                'location' => 'nullable|string|max:300',
                'start_date' => 'nullable|string|max:200',
                'end_date' => 'nullable|string|max:200',
                'status' => 'nullable|string|max:200',
                'event_type_id' => 'required|integer',
                'created_by' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->message()
                ], 422);
            } else {
                $ifExist = Events::where('event_name', $request->event_name)->get();

                if ($ifExist->count()) {
                    return response()->json([
                        'status' => 422,
                        'errors' => 'Record already exist.'
                    ], 422);
                } else {
                    $event = Events::create([
                        'event_name' => $request->event_name,
                        'event_subtitle' => $request->event_subtitle,
                        'location' => $request->location,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'status' => $request->status,
                        'event_type_id' => $request->event_type_id,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);

                    if ($event) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Record successfully added!'
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
    public function show(Events $events)
    {
        try {
            if ($events->count() > 0) {
                $newEvents = Events::join('tblevent_types', 'tblevent_types.event_type_id', '=', 'tblevents.event_type_id')
                                    ->select('tblevents.event_id', 'tblevents.event_name', 'tblevents.event_subtitle',
                                            'tblevents.location', 'tblevents.start_date', 'tblevents.end_date',
                                            'tblevents.status', 'tblevents.event_type_id', 'tblevent_types.event_type_name')
                                    ->get();
                
                return response()->json([
                    'status' => 200,
                    'body' => $newEvents
                ], 200);
                } else {
                    return response()->json([
                        'status' => 422,
                        'message' => 'No Records Found.'
                    ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Events $events)
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
                'event_name' => 'required|string:max:200',
                'event_subtitle' => 'nullable|string|max:200',
                'location' => 'nullable|string|max:300',
                'start_date' => 'nullable|string|max:200',
                'end_date' => 'nullable|string|max:200',
                'status' => 'nullable|string|max:200',
                'event_type_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->message()
                ], 422);
            } else {
                $event = Events::find($request->event_id);

                if ($event->event_name === $request->event_name & $event->event_subtitle === $request->event_subtitle & $event->start_date === $request->start_date & $event->end_date === $request->end_date & $event->status === $request->status & $event->event_type_id) {
                    return response()->json([
                        'status' => 422,
                        'errors' => 'No changes were made.'
                    ], 422);
                } else {
                    $event = Events::find($request->event_id)
                            ->update([
                                'event_name' => $request->event_name,
                                'event_subtitle' => $request->event_subtitle,
                                'location' => $request->location,
                                'start_date' => $request->start_date,
                                'end_date' => $request->end_date,
                                'status' => $request->status,
                                'event_type_id' => $request->event_type_id,
                            ]);

                    if ($event) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Record successfully updated!'
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
     * Remove the specified resource from storage.
     */
    public function destroy(Events $events, Request $request)
    {
        try {
            $events = Events::find($request->event_id);

            if ($events) {
                $events->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Record successfully deleted.'
                ]);
            }   else {
                return response()->json([
                    'status' => 422,
                    'message' => 'There was a problem deleting the record.'
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
