<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Response::macro('success', function (mixed $data, int $status, ?string $message = null) {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $status);
        });

        Response::macro('error', function (string $message, int $status, ?array $errors = null) {
            return Response::json([
                'success' => false,
                'message' => __($message),
                'data' => $errors
            ], $status);
        });
    }
}
