<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EventTypeController extends Controller
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
                'event_type_name' => 'required|string|max:191',
                'created_by' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->message()
                ], 422);
            } else {
                $eventType = EventType::create([
                    'event_type_name' => $request->event_type_name,
                    'created_by' => $request->created_by,
                    'created_on' => now()
                ]);

                if ($eventType) {
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
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EventType $eventType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventType $eventType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventType $eventType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventType $eventType)
    {
        //
    }
}
