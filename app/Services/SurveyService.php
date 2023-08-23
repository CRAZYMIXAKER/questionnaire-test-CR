<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\SurveyCollection;
use App\Http\Resources\SurveyResource;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     * @throws \App\Exceptions\NotFoundException
     */
    public function getAll(): AnonymousResourceCollection
    {
        $surveys = Survey::with('questions')->paginate(16);

        if ($surveys->isEmpty()) {
            throw new NotFoundException('Surveys not found.');
        }

        return SurveyResource::collection($surveys);
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
}
