<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Survey\SurveyRequest;
use App\Services\QuestionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends ApiController
{
    public function __construct(
        private readonly QuestionService $questionService
    ) {
    }

    /**
     * @param  \App\Http\Requests\Survey\SurveyRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotSurveyQuestions(SurveyRequest $request): JsonResponse
    {
        try {
            $questions = $this->questionService->getNotSurveyQuestions(
                (int)$request->validated('survey_id')
            );

            return $this->successResponse($questions->toArray());
        } catch (NotFoundException $error) {
            return $this->clientErrorsResponse(
                message: $error->getMessage(),
                code   : Response::HTTP_NOT_FOUND,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }
}
