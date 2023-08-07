<?php

namespace App\Services;

use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AnswerService
{

    public static function getUserData(): array
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
     * @param  int  $surveyId
     *
     * @return mixed
     */
    public function getAnswersBySurveyId(int $surveyId): mixed
    {
        $userData = self::getUserData();

        $answers = Answer::where([
            ['survey_id', '=', $surveyId],
            ['user_id', '=', $userData['user_id']],
            ['session_id', '=', $userData['session_id']],
        ])->get();

        return $answers->map(function ($answer) {
            return json_decode($answer->answer) ?? $answer->answer;
        });
    }

}
