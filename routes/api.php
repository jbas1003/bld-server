<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\ContactNumbersController;

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