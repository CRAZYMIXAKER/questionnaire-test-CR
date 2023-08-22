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

require __DIR__.'/auth.php';

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/surveys', [SurveyController::class, 'index']);
Route::get('/surveys/{survey_id}', [SurveyController::class, 'show']);

Route::middleware('survey.session')->group(function () {
    Route::post('/answers', [AnswerController::class, 'store']);
    Route::post(
        '/answers/temporary',
        [AnswerController::class, 'storeTemporaryAnswer']
    );
    Route::get(
        '/answers/{survey_id}',
        [AnswerController::class, 'getAnswersBySurveyId']
    );
    Route::get(
        '/surveys/{survey_id}/answers',
        [AnswerController::class, 'getModifiedAnswersBySurveyId']
    );
});
