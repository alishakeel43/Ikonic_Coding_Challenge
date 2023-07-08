<?php
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ReceiveRequestController;
use App\Http\Controllers\SendRequestController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
Route::post('/example_route', [SuggestionController::class, 'index']);
Route::get('/example_route', [SuggestionController::class, 'index']);

Route::get('/suggestion', [SuggestionController::class, 'index']);

Route::post('/send_request', [SendRequestController::class, 'store']);

Route::get('/send_request', [SendRequestController::class, 'index']);


Route::post('/receive_request', [ReceiveRequestController::class, 'store']);

Route::get('/receive_request', [ReceiveRequestController::class, 'index']);
Route::patch('/receive_request/{receiver_user_id}', [ReceiveRequestController::class, 'update']);


Route::post('/connection', [ConnectionController::class, 'store']);

Route::get('/connection', [ConnectionController::class, 'index']);

Route::get('/connection/{id}', [ConnectionController::class, 'show']);


Route::Delete('/connection/{id}', [ConnectionController::class, 'destroy']);



Route::Delete('/send_request/{receiver_user_id}', [SendRequestController::class, 'destroy']);

});
