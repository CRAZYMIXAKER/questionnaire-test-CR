<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{

    public function store()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $sessionId = request()->cookie('laravel_session');
        }

        Answer::where([
            ['survey_id', '=', request('survey_id')],
            ['user_id', '=', $userId ?? null],
            ['session_id', '=', $sessionId ?? null],
        ])->update(['status' => 'done']);
    }

    public function storeTemporary()
    {
        $answer = is_array(request('answer')) ?
            json_encode(request('answer')) :
            request('answer');

        $preparedAnswer = [
            'survey_id' => request('survey_id'),
            'question_id' => request('question_id'),
            'answer' => $answer,
            'status' => 'not done',
        ];

        if (Auth::check()) {
            $preparedAnswer['user_id'] = Auth::id();
        } else {
            $preparedAnswer['session_id'] = request()->cookie(
                'laravel_session'
            );
        }

        Answer::where([
            ['survey_id', '=', request('survey_id')],
            ['user_id', '=', $preparedAnswer['user_id'] ?? null],
            ['session_id', '=', $preparedAnswer['session_id'] ?? null],
        ])->update(['status' => 'not done']);

        if (isset($preparedAnswer['user_id']) ||
            isset($preparedAnswer['session_id'])) {
            Answer::updateOrCreate([
                'survey_id' => $preparedAnswer['survey_id'],
                'question_id' => $preparedAnswer['question_id'],
                'user_id' => $preparedAnswer['user_id'] ?? null,
                'session_id' => $preparedAnswer['session_id'] ?? null,
            ], $preparedAnswer);

            return response()->json(['message' => 'Temporary answer added']);
        }

        return response()->json(['error' => "Can't find any user data"]);
    }

    public function show()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $sessionId = request()->cookie('laravel_session');
        }

        //        return response()->json(request('survey_id'));
        //        return response()->json($userId ?? null);

        $answers = Answer::where([
            ['survey_id', '=', request('survey_id')],
            ['user_id', '=', $userId ?? null],
            ['session_id', '=', $sessionId ?? null],
            ['status', '=', 'not done'],
        ])->get();

        $temporaryAnswers = $answers->map(function ($answer) {
            return is_array($answer->answer) ? json_decode(
                $answer->answer
            ) : $answer->answer;
        });

        //        $temporaryAnswers = $answers->reduce(function ($carry, $answer) {
        //            $decodedAnswer = is_array($answer->answer) ? json_decode($answer->answer, true) : $answer->answer;
        //            $carry[] = $decodedAnswer;
        //            return $carry;
        //        }, []);

        //        var_dump(is_array($answers));
        //        $temporaryAnswers = array_map(static function ($answer) {
        //            var_dump($answer['answer']);
        //            if (is_array($answer['answer'])) {
        //                return json_decode($answer['answer']);
        //            } else {
        //                return $answer['answer'];
        //            }
        //        }, $answers);

        return response()->json($temporaryAnswers);
    }

}
