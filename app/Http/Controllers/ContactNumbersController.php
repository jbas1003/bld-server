<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactNumbers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactNumbersController extends Controller
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
                'mobile' => 'required|string|max:20',
                'created_by' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ]);
            } else {
                $contactNumber = ContactNumbers::create([
                    'mobile' => $request->mobile,
                    'created_by' => $request->created_by,
                    'created_on' => now()
                ]);

                if($contactNumber) {
                    return response()->json([
                        'status' => 200,
                        'contact_number' => $contactNumber->id
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 500,
                        'errors' => 'Server error.'
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
    public function show(ContactNumbers $contactNumbers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactNumbers $contactNumbers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactNumbers $contactNumbers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactNumbers $contactNumbers)
    {
        //
    }
}
