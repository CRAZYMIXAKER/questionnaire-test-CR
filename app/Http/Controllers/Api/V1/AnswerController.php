<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Answer\GetAnswersBySurveyIdRequest;
use App\Http\Requests\Answer\StoreAnswerRequest;
use App\Http\Requests\Answer\StoreTemporaryAnswerRequest;
use App\Services\AnswerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends ApiController
{
    public function __construct(private readonly AnswerService $answerService
    ) {}

    /**
     * @param  \App\Http\Requests\Answer\StoreAnswerRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAnswerRequest $request): JsonResponse
    {
        try {
            $this->answerService->storeAnswer(
                (int)$request->validated('survey_id')
            );

            return $this->successResponse(
                code: Response::HTTP_CREATED,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    /**
     * @param  \App\Http\Requests\Answer\StoreTemporaryAnswerRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTemporaryAnswer(StoreTemporaryAnswerRequest $request
    ): JsonResponse {
        try {
            $this->answerService->storeTemporaryAnswer($request->validated());

            return $this->successResponse();
        } catch (NotFoundException $error) {
            return $this->clientErrorsResponse(
                message: $error->getMessage(),
                code: Response::HTTP_NOT_FOUND,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    /**
     * @param  \App\Http\Requests\Answer\GetAnswersBySurveyIdRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnswersBySurveyId(GetAnswersBySurveyIdRequest $request
    ): JsonResponse {
        try {
            $answers = $this->answerService->getAnswersBySurveyId(
                (int)$request->validated('survey_id')
            );

            return $this->successResponse($answers->toArray());
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    /**
     * @param  \App\Http\Requests\Answer\GetAnswersBySurveyIdRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getModifiedAnswersBySurveyId(
        GetAnswersBySurveyIdRequest $request
    ): JsonResponse {
        try {
            $answers = $this->answerService->getModifiedAnswersBySurveyId(
                (int)$request->validated('survey_id')
            );

            return $this->successResponse($answers->toArray());
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }
}
