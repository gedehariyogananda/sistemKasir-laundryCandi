<?php

use App\Http\Controllers\API\UserPurchasedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/loundry')->group(function () {
    Route::get('/get/data-customer', [UserPurchasedController::class, 'getAllDataCustomer']);
    Route::get('/note-purchased/{id}', [UserPurchasedController::class, 'getPrintNoteCustomer']);
    Route::post('/add/data-customer', [UserPurchasedController::class, 'insertDataCustomer']);
    Route::patch('/update/data-customer', [UserPurchasedController::class, 'updateOtherData']);
    Route::delete('/delete/data-customer/{id}', [UserPurchasedController::class, 'destroyData']);
});
