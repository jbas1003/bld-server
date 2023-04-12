<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberAccounts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MemberAccountsController extends Controller
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
                'member_id' => 'required|integer',
                'username' => 'required|string|max:10|unique:tblmember_accounts',
                'password' => 'required|string|max:16',
                'created_by' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages()
                ]);
            } else {
                $ifExist = MemberAccounts::where('member_id', $request->member_id);

                if ($ifExist->count() > 0) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Record already existed'
                    ]);
                } else {
                    $account = MemberAccounts::create([
                        'member_id' => $request->member_id,
                        'username' => $request->username,
                        'password' => $request->password,
                        'created_by' => $request->created_by,
                        'created_on' => now()
                    ]);

                    if ($account) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Record successfully added!'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 422,
                            'message' => 'An issue was encountered while adding the record. Please contact systems administrator.'
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
    public function show(MemberAccounts $memberAccounts)
    {
        
        try {
            if ($memberAccounts->count() > 0) {
                $accounts = MemberAccounts::join('tblmembers', 'tblmember_accounts.member_id', '=', 'tblmembers.member_id')
                                            ->select('tblmembers.member_id','tblmembers.first_name', 'tblmembers.middle_name', 'tblmembers.last_name',
                                                    'tblmember_accounts.username')
                                            ->get();
                return response()->json([
                    'status' => 200,
                    'body' => $accounts
                ], 200);
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
    public function edit(MemberAccounts $memberAccounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MemberAccounts $memberAccounts)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:10|unique:tblmember_accounts',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages()
                ]);
            } else {
                $account = MemberAccounts::find($request->memberAccount_id);
                
                if ($account->username === $request->username) {
                    return responsse()->json([
                        'status' => 422,
                        'message' => 'No changes were made.'
                    ], 422);
                } else {
                    $account->update([
                        'username' => $request->username
                    ]);
    
                    if ($account) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Record successfully updated!'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 422,
                            'message' => 'An issue was encountered while updating the record. Please contact systems administrator.'
                        ]);
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
    public function destroy(MemberAccounts $memberAccounts, Request $request)
    {
        try {
            if ($memberAccounts->count() > 0) {
                $account = MemberAccounts::find($request->memberAccount_id)
                        ->delete();

                if ($account) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Record was successfully deleted.'
                    ]);
                } else {
                    return response()->json([
                        'status' => 422,
                        'message' => 'A problem was encountered while trying to delete the record. Please contact system administrator.'
                    ]);
                }
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
}
