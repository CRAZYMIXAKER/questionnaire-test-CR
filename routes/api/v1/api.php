<?php

use App\Http\Controllers\Api\V1\AnswerController;
use App\Http\Controllers\Api\V1\SurveyController;
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

Route::get('/surveys/{survey}', [SurveyController::class, 'show']);
Route::middleware('survey.session')->group(function () {
    Route::post('/answers', [AnswerController::class, 'store']);
    Route::post(
        '/answers/temporary',
        [AnswerController::class, 'storeTemporaryAnswer']
    );
    Route::get(
        '/answers/temporary/{survey_id}',
        [AnswerController::class, 'getAnswersBySurveyId']
    );
});
