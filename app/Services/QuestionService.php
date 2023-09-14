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
        return Question::whereDoesntHave(
            'surveys',
            function ($query) use ($surveyId) {
                $query->where('survey_id', $surveyId);
            }
        )
            ->where('parent_id', '=', null)
            ->paginate(10);
    }
}
