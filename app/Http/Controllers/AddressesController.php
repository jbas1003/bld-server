<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AddressesController extends Controller
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
                'address_line1' => 'nullable|string|max:191',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:191',
                'created_by' => 'required|string|max:191',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ], 422);
            } else {
                $address = Addresses::create([
                    'address_line1' => $request->address_line1,
                    'address_line2' => $request->address_line2,
                    'city' => $request->city,
                    'created_by' => $request->created_by,
                    'created_on' => now(),
                ]);

                if ($address) {
                    return response()->json([
                        'status' => 200,
                        'address' => $address->id
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 500,
                        'Error' => 'Server Error!'
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
    public function show(Addresses $addresses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Addresses $addresses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Addresses $addresses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addresses $addresses)
    {
        //
    }
}
