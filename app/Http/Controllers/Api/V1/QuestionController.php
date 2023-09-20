<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Question\QuestionRequest;
use App\Http\Requests\Question\StoreNestingQuestionRequest;
use App\Http\Requests\Question\StoreQuestionRequest;
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

    public function show(QuestionRequest $request): JsonResponse
    {
        try {
            $questionResource = $this->questionService->getQuestion(
                (int)$request->validated('id')
            );

            return $this->successResponse($questionResource->resolve());
        } catch (NotFoundException $error) {
            return $this->clientErrorsResponse(
                message: $error->getMessage(),
                code   : Response::HTTP_NOT_FOUND,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
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

    public function destroy(QuestionRequest $request): JsonResponse
    {
        try {
            $this->questionService->deleteQuestion(
                (int)$request->validated('id')
            );

            return $this->successResponse(
                message: 'Question was successful deleted'
            );
        } catch (NotFoundException $error) {
            return $this->clientErrorsResponse(
                message: $error->getMessage(),
                code   : Response::HTTP_NOT_FOUND,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    public function storeNestingQuestion(
        StoreNestingQuestionRequest $request
    ): JsonResponse {
        try {
            $this->questionService->storeNestingQuestion(
                $request->validated('text'),
                $request->validated('type'),
                $request->validated('parent_id'),
            );

            return $this->successResponse(
                message: 'Nesting question was successful added!'
            );
        } catch (NotFoundException $error) {
            return $this->clientErrorsResponse(
                message: $error->getMessage(),
                code   : Response::HTTP_NOT_FOUND,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    /**
     * @param  \App\Http\Requests\Question\QuestionRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(QuestionRequest $request): JsonResponse
    {
        try {
            $this->questionService->updateQuestion($request->validated());

            return $this->successResponse(
                message: 'Question was successful updated'
            );
        } catch (NotFoundException $error) {
            return $this->clientErrorsResponse(
                message: $error->getMessage(),
                code   : Response::HTTP_NOT_FOUND,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    /**
     * @param  \App\Http\Requests\Question\QuestionRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateType(QuestionRequest $request): JsonResponse
    {
        try {
            $this->questionService->updateQuestionType(
                $request->validated('id'),
                $request->validated('type'),
            );

            return $this->successResponse(
                message: 'Question type was successful updated'
            );
        } catch (NotFoundException $error) {
            return $this->clientErrorsResponse(
                message: $error->getMessage(),
                code   : Response::HTTP_NOT_FOUND,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    /**
     * @param  \App\Http\Requests\Question\StoreQuestionRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreQuestionRequest $request): JsonResponse
    {
        try {
            $this->questionService->storeQuestion($request->validated());

            return $this->successResponse(
                message: 'Question was successful created!'
            );
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
