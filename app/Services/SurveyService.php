<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\SurveyResource;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @return LengthAwarePaginator
     * @throws \App\Exceptions\NotFoundException
     */
    public function getAll(): LengthAwarePaginator
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
        $survey->questions->load('nestings');

        return new SurveyResource($survey);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \App\Exceptions\NotFoundException
     */
    public function getSurveysQuestions(): LengthAwarePaginator
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
     * @throws \App\Exceptions\NotFoundException
     */
    public function deleteSurvey(int $surveyId): void
    {
        $survey = $this->findSurvey($surveyId);
        $survey->questions()->detach();
        $survey->delete();
    }

    /**
     * @param  int  $surveyId
     * @param  int  $questionId
     *
     * @return void
     * @throws \App\Exceptions\NotFoundException
     */
    public function deleteSurveysQuestion(int $surveyId, int $questionId): void
    {
        $survey = $this->findSurvey($surveyId);
        $survey->questions()->detach($questionId);
    }

    /**
     * @param  int  $surveyId
     * @param  array  $data
     *
     * @return void
     * @throws \App\Exceptions\NotFoundException
     */
    public function updateSurvey(int $surveyId, array $data): void
    {
        $survey = $this->findSurvey($surveyId);
        $survey->update($data);
    }

    /**
     * @param  int  $surveyId
     * @param  array  $questionIds
     *
     * @return void
     * @throws \App\Exceptions\NotFoundException
     */
    public function storeQuestions(int $surveyId, array $questionIds): void
    {
        $survey = $this->findSurvey($surveyId);

        try {
            Question::findOrFail($questionIds);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("Questions not found");
        }

        $survey->questions()->attach($questionIds);
    }
}
