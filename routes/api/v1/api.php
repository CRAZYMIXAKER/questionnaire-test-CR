<?php

use App\Http\Controllers\Api\V1\AnswerController;
use App\Http\Controllers\Api\V1\QuestionController;
use App\Http\Controllers\Api\V1\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

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
    Route::match(
        ['put', 'patch'],
        '/surveys/{survey_id}',
        [SurveyController::class, 'update']
    );
    Route::delete(
        '/surveys/{survey_id}',
        [SurveyController::class, 'destroy']
    );

    Route::get(
        '/survey/questions',
        [SurveyController::class, 'surveysQuestions']
    );
    Route::delete(
        '/survey/questions/{survey_id}/{question_id}',
        [SurveyController::class, 'destroyQuestion']
    );
    Route::post(
        '/survey/questions/create',
        [SurveyController::class, 'storeQuestions']
    );

    Route::get(
        '/not-survey-questions/{survey_id}',
        [QuestionController::class, 'getNotSurveyQuestions']
    );

    // change question for surveys-questions
});
