<?php

namespace App\Http\Requests;

use ArrayAccess;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Urameshibr\Requests\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * @param array|mixed $array
     * @return array
     */
    public function mergeValidData($array = []): array
    {
        return Arr::collapse([$this->validated(), $array]);
    }

    /**
     * @return array
     */
    public function validated(): array
    {
        return $this->getValidatorInstance()->validated();
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->responseMessage(),
            'attr' => [],
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return string
     */
    public function responseMessage(): string
    {
        return __('lang.default.form-request');
    }

    /**
     * Get the response for a forbidden operation.
     *
     * @return JsonResponse
     */
    public function forbiddenResponse(): JsonResponse
    {
        return new JsonResponse([
            'message' => "Forbidden",
            'attr' => [],
            'errors' => []
        ], Response::HTTP_FORBIDDEN, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param null $param
     * @param null $default
     * @return array|ArrayAccess|Route|mixed|object|string|null
     */
    public function route($param = null, $default = null)
    {
        $route = ($this->getRouteResolver())();

        if (is_null($route) || is_null($param)) {
            return $route;
        }

        return Arr::get($route[2], $param, $default);
    }

    protected function failedAuthorization()
    {
        response()->json([
            'message' => "Giriş yapmalısınız!",
            'attr' => [],
            'errors' => []
        ], Response::HTTP_UNAUTHORIZED, [], JSON_UNESCAPED_UNICODE)->send();
        die();
    }
}
