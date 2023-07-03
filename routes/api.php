<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoireController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\AuthController;

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
Route::get('/histoires',[HistoireController::class, 'index']);
Route::post('/histoires',[HistoireController::class,'save']);
Route::post('/famille_histoires',[FamilleController::class,'save']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/paiement', [PaymentController::class,'processPayment']);
Route::get('/payment/checkout', 'PaymentController@checkout');
Route::get('', 'PaymentController@checkout');

Route::group(['middleware' => ['auth:sanctum']],function()
 {
    //return $request->user();
});