<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Question;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorAlias;

class QuestionService
{
    /**
     * @param  int  $surveyId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \App\Exceptions\NotFoundException
     */
    public function getNotSurveyQuestions(
        int $surveyId
    ): LengthAwarePaginatorAlias {
        $questions = Question::whereDoesntHave('surveys', function ($query) {
            $query->where('survey_id', 13);
        })->paginate(1);

        if ($questions->isEmpty()) {
            throw new NotFoundException('Questions not found.');
        }

        return $questions;
    }
}
