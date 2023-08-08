<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Answer\GetAnswersBySurveyIdRequest;
use App\Http\Requests\Answer\StoreAnswerRequest;
use App\Models\Answer;
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
        $validatedParams = $request->validated();

        try {
            $this->answerService->storeAnswer(
                (int)$validatedParams['survey_id']
            );
            return $this->successResponse(
                code: Response::HTTP_CREATED,
            );
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    public function storeTemporaryAnswer()
    {
        $userData = AnswerService::getUserData();
        $preparedAnswer = is_array(request('answer')) ?
            json_encode(request('answer')) :
            request('answer');

        $answer = [
            'survey_id' => request('survey_id'),
            'question_id' => request('question_id'),
            'user_id' => $userData['user_id'],
            'session_id' => $userData['session_id'],
            'answer' => $preparedAnswer,
            'status' => 'not done',
        ];

        if ($answer['user_id'] || $answer['session_id']) {
            Answer::updateOrCreate([
                'survey_id' => $answer['survey_id'],
                'question_id' => $answer['question_id'],
                'user_id' => $answer['user_id'],
                'session_id' => $answer['session_id'],
            ], $answer);

            /**
             * Update the statuses of all questions if the user decides
             * to change their answers in a completed questionnaire.
             */
            Answer::where([
                ['user_id', '=', $answer['user_id']],
                ['session_id', '=', $answer['session_id']],
            ])->update(['status' => 'not done']);

            return response()->json('Fine');
        }

        return response()->json(['error' => "Can't find any user data"]);
    }

    /**
     * @param  \App\Http\Requests\Answer\GetAnswersBySurveyIdRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnswersBySurveyId(GetAnswersBySurveyIdRequest $request
    ): JsonResponse {
        $validatedParams = $request->validated();

        try {
            $answers = $this->answerService->getAnswersBySurveyId(
                (int)$validatedParams['survey_id']
            );
            return $this->successResponse(['answers' => $answers]);
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

}
