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
                'event_name' => 'required|string:max:200',
                'event_subtitle' => 'nullable|string|max:200',
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
        //
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
    public function update(Request $request, Events $events)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Events $events)
    {
        //
    }
}
