<?php

namespace App\Http\Controllers;

use App\Models\Occupation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OccupationController extends Controller
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
                'occupation_name' => 'required|string|max:191',
                'specialty' => 'required|string|max:191',
                'company' => 'required|string|max:191',
                'address_id' => 'nullable|integer',
                'created_by' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ]);
            } else {
                $occupation = Occupation::create([
                    'occupation_name' => $request->occupation_name,
                    'specialty' => $request->specialty,
                    'company' => $request->company,
                    'address_id' => $request->address_id,
                    'created_by' => $request->created_by,
                    'created_on' => now()
                ]);

                if ($occupation) {
                    return response()->json([
                        'status' => 200,
                        'occupation' => $occupation->id
                    ]);
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
    public function show(Occupation $occupation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Occupation $occupation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Occupation $occupation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Occupation $occupation)
    {
        //
    }
}
