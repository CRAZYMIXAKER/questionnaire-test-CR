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

    Route::get('/surveys', [SurveyController::class, 'index']);
    Route::get(
        '/surveys/questions',
        [SurveyController::class, 'surveysQuestions']
    );
    Route::get('/surveys/{survey_id}', [SurveyController::class, 'show']);
    Route::post(
        '/survey/questions/create',
        [SurveyController::class, 'storeQuestions']
    );
    Route::delete(
        '/surveys/{survey_id}',
        [SurveyController::class, 'destroy']
    );
    Route::delete(
        '/surveys/{survey_id}/questions/{question_id}',
        [SurveyController::class, 'destroyQuestion']
    );
    Route::match(
        ['put', 'patch'],
        '/surveys/{survey_id}',
        [SurveyController::class, 'update']
    );

    Route::get(
        '/not-survey-questions/{survey_id}',
        [QuestionController::class, 'getNotSurveyQuestions']
    );
    Route::get('/questions/{id}', [QuestionController::class, 'show']);
    Route::post(
        '/questions/nesting',
        [QuestionController::class, 'storeNestingQuestion']
    );
    Route::delete(
        '/questions/{id}',
        [QuestionController::class, 'destroy']
    );
    Route::patch(
        '/questions/{id}/type',
        [QuestionController::class, 'updateType']
    );
    Route::match(
        ['put', 'patch'],
        '/questions/{id}',
        [QuestionController::class, 'update']
    );
});
