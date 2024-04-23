<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\SubscriptionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('events', [EventsController::class, 'index']);
Route::get('events/{id}', [EventsController::class, 'searchEventParticipants']);
Route::get('subscriptions/{id}', [SubscriptionsController::class, 'searchSubscription']);
Route::post('susbcriptions', [SubscriptionsController::class, 'register']);
