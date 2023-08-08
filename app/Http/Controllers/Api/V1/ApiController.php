<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public const SERVER_ERROR_MESSAGE = 'There is unexpected error. Please, try again later.';

    public const CLIENT_ERROR_MESSAGE = 'There is something wrong with request. Please, try again.';

    /**
     * @param  array<mixed>  $data
     */
    final public function successResponse(
        array $data = [],
        string $message = 'Success',
        int $code = Response::HTTP_OK,
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * @param  array<mixed>  $data
     */
    final public function clientErrorsResponse(
        array $data = [],
        string $message = self::CLIENT_ERROR_MESSAGE,
        int $code = Response::HTTP_BAD_REQUEST,
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'errors' => $data,
        ], $code);
    }

    /**
     * @param  array<mixed>  $data
     */
    final public function serverErrorResponse(
        array $data = [],
        string $message = self::SERVER_ERROR_MESSAGE,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'errors' => $data,
        ], $code);
    }
}
