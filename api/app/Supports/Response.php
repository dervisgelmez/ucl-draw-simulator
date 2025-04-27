<?php

namespace App\Supports;

use App\Enums\ResponseStatusEnum;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Response
{
    /**
     * @param mixed|null $data
     * @param ResponseStatusEnum $status
     * @param string|null $message
     * @return JsonResponse
     */
    public static function success(
        mixed $data = null,
        ResponseStatusEnum $status = ResponseStatusEnum::OK,
        ?string $message = null
    ): JsonResponse
    {
        return response()->success($data, $status->value, $message);
    }

    /**
     * @param string $errorMessage
     * @param ResponseStatusEnum $status
     * @return JsonResponse
     */
    public static function error(
        string $errorMessage = 'error.unprocessable',
        ResponseStatusEnum $status = ResponseStatusEnum::BAD_REQUEST,
    ): JsonResponse
    {
        return response()->error($errorMessage, $status->value)->send();
    }

    /**
     * @param HttpException $exception
     * @return JsonResponse
     */
    public static function exception(HttpException $exception): JsonResponse
    {
        return response()->error($exception->getMessage(), $exception->getStatusCode())->send();
    }
}
