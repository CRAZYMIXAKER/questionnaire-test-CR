<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Survey;

class SurveyController extends Controller
{

    public function get(Survey $survey)
    {
        $questions = $survey->questions;
        $questionIds = $questions->pluck('id')->toArray();
        $nestedQuestions = Question::whereIn('parent_id', $questionIds)->get();

        $questions->transform(function ($question) use ($nestedQuestions) {
            $question->nestings = $nestedQuestions->where(
                'parent_id',
                $question->id
            );
            return $question;
        });

        //                var_dump($aa);
        return response()->json($survey);
    }

    //    public function getAll(): JsonResponse
    //    {
    //        try {
    //            $skills = $this->skillService->getAll();
    //            return $this->successResponse($skills);
    //        } catch (Exception) {
    //            return $this->serverErrorResponse();
    //        }
    //    }
}
