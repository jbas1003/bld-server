<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\MemberStatusController;
use App\Http\Controllers\ContactNumbersController;
use App\Http\Controllers\MemberAccountsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

// START: Members Routes

Route::get('members', [MembersController::class, 'show']);
Route::post('members', [MembersController::class, 'store']);
Route::put('members', [MembersController::class, 'update']);

// END: Members Routes

// START: Addresses Routes

Route::get('addresses', [AddressesController::class, 'show']);
Route::post('addresses', [AddressesController::class, 'store']);

// END: Addresses Routes

// START: Occupations Routes

Route::get('occupations', [OccupationController::class, 'show']);
Route::post('occupations', [OccupationController::class, 'store']);

// END: Occupations Routes

// START: Contact Numbers Routes

Route::get('contact_numbers', [ContactNumbersController::class, 'show']);
Route::post('contact_numbers', [ContactNumbersController::class, 'store']);

// END: Contact Numbers Routes

// START: Emails Routes

Route::get('emails', [EmailsController::class, 'show']);
Route::post('emails', [EmailsController::class, 'store']);

// END: Emails Routes

// START: Events Routes

Route::get('events', [EventsController::class, 'show']);
Route::post('events', [EventsController::class, 'store']);
Route::put('events', [EventsController::class, 'update']);
Route::delete('events', [EventsController::class, 'destroy']);


// END: Events Routes

// START: Event Types Routes

Route::get('event_types', [EventTypeController::class, 'show']);
Route::post('event_types', [EventTypeController::class, 'store']);
Route::put('event_types', [EventTypeController::class, 'update']);
Route::delete('event_types', [EventTypeController::class, 'destroy']);

// END: Event Types Routes

// START: Member Status Routes

Route::get('member_status', [MemberStatusController::class, 'show']);
Route::post('member_status', [MemberStatusController::class, 'store']);
Route::put('member_status', [MemberStatusController::class, 'update']);
Route::delete('member_status', [MemberStatusController::class, 'destroy']);

// END: Member Status Routes

// START: Member Accounts Routes

Route::post('member_accounts/login', [MemberAccountsController::class, 'login']);

Route::get('member_accounts', [MemberAccountsController::class, 'show']);
Route::post('member_accounts', [MemberAccountsController::class, 'store']);
Route::put('member_accounts', [MemberAccountsController::class, 'update']);
Route::delete('member_accounts', [MemberAccountsController::class, 'destroy']);

// END: Member Accounts Routes

// START: Attendance Routes

Route::get('attendances', [AttendanceController::class, 'show']);
Route::post('show_attendances', [AttendanceController::class, 'showAttendance']);
Route::post('attendances', [AttendanceController::class, 'store']);

// END: Attendance Routes