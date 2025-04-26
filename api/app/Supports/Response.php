<?php

namespace App\Supports;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Response
{
    /**
     * @param mixed|null $data
     * @param int $status
     * @param string|null $message
     * @return JsonResponse
     */
    public static function success(
        mixed $data = null,
        int $status = 200,
        ?string $message = null
    ): JsonResponse
    {
        return response()->success($data, $status, $message);
    }

    /**
     * @param string $errorMessage
     * @param int $status
     * @return JsonResponse
     */
    public static function error(
        string $errorMessage = 'error.unprocessable',
        int $status = 200
    ): JsonResponse
    {
        return response()->error($errorMessage, $status)->send();
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
