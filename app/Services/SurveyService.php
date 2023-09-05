<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorAlias;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyService
{
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

    /**
     * @return LengthAwarePaginatorAlias
     * @throws \App\Exceptions\NotFoundException
     */
    public function getAll(): LengthAwarePaginatorAlias
    {
        $surveys = Survey::with('questions')->paginate(16);

        if ($surveys->isEmpty()) {
            throw new NotFoundException('Surveys not found.');
        }

        return $surveys;
    }

    /**
     * @param  int  $surveyId
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     * @throws \App\Exceptions\NotFoundException
     */
    public function getSurvey(int $surveyId): JsonResource
    {
        $survey = $this->findSurvey($surveyId);
        $questions = $survey->questions->load('nestings');

        if ($questions->isEmpty()) {
            throw new NotFoundException('Questions not found for this survey.');
        }

        return new SurveyResource($survey);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \App\Exceptions\NotFoundException
     */
    public function getSurveysQuestions(): LengthAwarePaginatorAlias
    {
        $surveys = Survey::with('questions', 'questions.nestings')
            ->paginate(16);

        if ($surveys->isEmpty()) {
            throw new NotFoundException('Surveys not found.');
        }

        return $surveys;
    }

    /**
     * @param  int  $surveyId
     *
     * @return void
     */
    public function deleteSurvey(int $surveyId): void
    {
        $survey = Survey::find($surveyId);
        $survey->questions()->detach();
        $survey->delete();
    }
}
