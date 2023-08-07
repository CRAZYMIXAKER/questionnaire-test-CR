<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Ramsey\Uuid\Uuid;

class AnswerController extends Controller
{

    /**
     * @return array{user_id: int|null|string, session_id: null|string}
     */
    private static function getUserData(): array
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $sessionId = request()->cookie('survey_session');
        }

        return [
            'user_id' => $userId ?? null,
            'session_id' => $sessionId ?? null,
        ];
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): JsonResponse
    {
        $userData = self::getUserData();

        Answer::where([
            ['survey_id', '=', request('survey_id')],
            ['user_id', '=', $userData['user_id']],
            ['session_id', '=', $userData['session_id']],
        ])->update(['status' => 'done']);

        return response()->json('');
    }

    public function storeTemporaryAnswer()
    {
        $userData = self::getUserData();
        $preparedAnswer = is_array(request('answer')) ?
            json_encode(request('answer')) :
            request('answer');

        $answer = [
            'survey_id' => request('survey_id'),
            'question_id' => request('question_id'),
            'user_id' => $userData['user_id'],
            'session_id' => $userData['session_id'],
            'answer' => $preparedAnswer,
            'status' => 'not done',
        ];

        if ($answer['user_id'] || $answer['session_id']) {
            Answer::updateOrCreate([
                'survey_id' => $answer['survey_id'],
                'question_id' => $answer['question_id'],
                'user_id' => $answer['user_id'],
                'session_id' => $answer['session_id'],
            ], $answer);

            /**
             * Update the statuses of all questions if the user decides
             * to change their answers in a completed questionnaire.
             */
            Answer::where([
                ['user_id', '=', $answer['user_id']],
                ['session_id', '=', $answer['session_id']],
            ])->update(['status' => 'not done']);

            return response()->json('Fine');
        }

        return response()->json(['error' => "Can't find any user data"]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Facades\Response
     */
    public function getAnswers(): Response|JsonResponse
    {
        $userData = self::getUserData();

        $answers = Answer::where([
            ['survey_id', '=', request('survey_id')],
            ['user_id', '=', $userData['user_id']],
            ['session_id', '=', $userData['session_id']],
        ])->get();

        $answers = $answers->map(function ($answer) {
            return json_decode($answer->answer) ?? $answer->answer;
        });

        return response()->json($answers);
    }

}
