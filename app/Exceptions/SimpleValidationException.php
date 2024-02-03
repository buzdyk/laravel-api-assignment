<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class SimpleValidationException extends ValidationException
{
    public function render($request): JsonResponse
    {
        $error = $this->validator->errors()->first();

        return new JsonResponse([
            'message' => $error,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}
