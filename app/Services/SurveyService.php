<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Question;
use App\Models\Survey;

class SurveyService
{

    /**
     * @param  int  $surveyId
     *
     * @return \App\Models\Survey
     * @throws \App\Exceptions\NotFoundException
     */
    public function getSurvey(int $surveyId): Survey
    {
        $survey = $this->findSurvey($surveyId);
        $questions = $survey->questions;

        if ($questions->isEmpty()) {
            throw new NotFoundException('Questions not found for this survey.');
        }

        $questionIds = $questions->pluck('id')->toArray();
        $nestedQuestions = Question::whereIn('parent_id', $questionIds)->get();

        $questions->transform(function ($question) use ($nestedQuestions) {
            $question->nestings = $nestedQuestions->where(
                'parent_id',
                $question->id
            );
            return $question;
        });

        return $survey;
    }

    /**
     * @throws \App\Exceptions\NotFoundException
     */
    private function findSurvey(int $surveyId): Survey
    {
        $survey = Survey::find($surveyId);
        if (!$survey) {

            throw new NotFoundException(
                sprintf('Not found survey with id %d.', $surveyId),
            );
        }

        return $survey;
    }

}
