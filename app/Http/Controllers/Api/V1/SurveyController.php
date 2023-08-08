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
     * @param  \App\Http\Requests\Survey\SurveyRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SurveyRequest $request): JsonResponse
    {
        $validatedParams = $request->validated();

        try {
            $survey = $this->surveyService->getSurvey(
                (int)$validatedParams['survey_id']
            );
            return $this->successResponse(['survey' => $survey]);
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
