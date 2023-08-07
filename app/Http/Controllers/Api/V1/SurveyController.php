<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Survey;

class SurveyController extends Controller
{

    public function show(Survey $survey)
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
