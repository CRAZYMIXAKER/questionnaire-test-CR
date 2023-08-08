<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class AnswerService
{

    /**
     * @return array{user_id: int|null|string, session_id: array|null|string}
     */
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
     * @return void
     */
    public function storeAnswer(int $surveyId): void
    {
        $userData = self::getUserData();

        Answer::where([
            ['survey_id', '=', $surveyId],
            ['user_id', '=', $userData['user_id']],
            ['session_id', '=', $userData['session_id']],
        ])->update(['status' => 'done']);
    }

    /**
     * @param  array  $answerData
     *
     * @return bool
     * @throws \App\Exceptions\NotFoundException
     */
    public function storeTemporaryAnswer(array $answerData): bool
    {
        $userData = self::getUserData();
        $preparedAnswer = is_array($answerData['answer']) ?
            json_encode($answerData['answer']) :
            $answerData['answer'];

        $answer = [
            'survey_id' => $answerData['survey_id'],
            'question_id' => $answerData['question_id'],
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

            return true;
        }

        throw new NotFoundException('Not found any user data');
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

    public function getModifiedAnswersBySurveyId(int $surveyId)
    {
        $userData = self::getUserData();

        $answers = Answer::where([
            ['survey_id', '=', $surveyId],
            ['user_id', '=', $userData['user_id']],
            ['session_id', '=', $userData['session_id']],
        ])->get();

        return $answers->map(function ($answer) {
            if ($answer->question->type === 'select') {
                return $answer->question->text;
            }

            return json_decode($answer->answer) ?? $answer->answer;
        });
    }

}
