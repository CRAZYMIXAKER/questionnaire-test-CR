<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Survey\SurveyRequest;
use App\Services\SurveyService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SurveyController extends ApiController
{

    public function __construct(private readonly SurveyService $surveyService
    ) {}

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $surveys = $this->surveyService->getAll();

            return $this->successResponse($surveys->toArray());
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
     * @param  \App\Http\Requests\Survey\SurveyRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SurveyRequest $request): JsonResponse
    {
        try {
            $surveyResource = $this->surveyService->getSurvey(
                (int)$request->validated('survey_id')
            );

            return $this->successResponse($surveyResource->resolve());
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
     * @param  \App\Http\Requests\Survey\SurveyRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SurveyRequest $request): JsonResponse
    {
        try {
            $this->surveyService->deleteSurvey(
                (int)$request->validated('survey_id')
            );

            return $this->successResponse(
                code: Response::HTTP_CREATED,
            );
        } catch (NotFoundException $error) {
            return $this->clientErrorsResponse(
                message: $error->getMessage(),
                code: Response::HTTP_NOT_FOUND,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

}
