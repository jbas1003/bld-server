<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmailsController extends Controller
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
                'email' => 'nullable|string|max:191',
                'created_by' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->message()
                ], 422);
            } else {
                $ifExists = Emails::where('email', $request->email);

                if ($ifExists) {
                    return response()->json([
                        'status' => 422,
                        'errors' => 'Email already exist.'
                    ]);
                } else {
                    $email = Emails::create([
                        'email' => $request->email,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);
    
                    if ($email) {
                        return response()->json([
                            'status' => 200,
                            'email' => $email->id
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
    public function show(Emails $emails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Emails $emails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Emails $emails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emails $emails)
    {
        //
    }
}
