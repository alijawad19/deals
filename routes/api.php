<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealsController;


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

Route::post('/create-deal', [DealsController::class, 'createDeal']);
Route::get('/list-deals', [DealsController::class, 'showDeals']);
Route::post('/claim-deal', [DealsController::class, 'claimDeal']);
Route::put('/update-deal/{id}',[DealsController::class,'update']);
