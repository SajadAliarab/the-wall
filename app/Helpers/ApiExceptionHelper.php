<?php

namespace App\Helpers;

use App\Contracts\Exceptions\CustomExceptionInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class ApiExceptionHelper
{
    public function __construct(
        protected Throwable $throwable,
        protected Request $request,
    ) {}

    public function handleAPIException(): JsonResponse
    {
        return match (true) {
            AppHelper::isDevMode() && $this->throwable instanceof MethodNotAllowedHttpException => $this->methodNotAllowedError(),
            AppHelper::isDevMode() && $this->throwable instanceof RouteNotFoundException => $this->routeNotFoundError(),
            $this->throwable instanceof ModelNotFoundException => $this->modelNotFoundError(),
            $this->throwable instanceof NotFoundHttpException => $this->dataNotFoundError(),
            $this->throwable instanceof TooManyRequestsHttpException => $this->tooManyRequestsError(),
            $this->throwable instanceof ValidationException => $this->validationError(),
            $this->throwable instanceof AuthenticationException => $this->authenticationError(),
            $this->throwable instanceof AuthorizationException, $this->throwable instanceof AccessDeniedHttpException, => $this->authorizationError(),
            $this->throwable instanceof CustomExceptionInterface => $this->customError($this->throwable),
            default => $this->serverError($this->throwable),
        };
    }

    protected function modelNotFoundError(): JsonResponse
    {
        return response()->apiError(
            messages: __('exceptions/global.model_not_found'),
            responseCode: Response::HTTP_NOT_FOUND,
        );
    }

    protected function methodNotAllowedError(): JsonResponse
    {
        return response()->apiError(
            messages: __('exceptions/global.method_not_allowed'),
            responseCode: Response::HTTP_METHOD_NOT_ALLOWED,
        );
    }

    protected function routeNotFoundError(): JsonResponse
    {
        return response()->apiError(
            messages: __('exceptions/global.route_not_found'),
            responseCode: Response::HTTP_NOT_FOUND,
        );
    }

    protected function dataNotFoundError(): JsonResponse
    {
        return response()->apiError(
            messages: __('exceptions/global.data_not_found'),
            responseCode: Response::HTTP_NOT_FOUND,
        );
    }

    protected function tooManyRequestsError(): JsonResponse
    {
        return response()->apiError(
            messages: __('exceptions/global.too_many_requests'),
            responseCode: Response::HTTP_TOO_MANY_REQUESTS,
        );
    }

    protected function couldNotPerformTransitionError(): JsonResponse
    {
        return response()->apiError(
            messages: __('exceptions/global.could_not_perform_transition'),
            responseCode: Response::HTTP_BAD_REQUEST,
        );
    }

    protected function validationError(): JsonResponse
    {
        /** @var ValidationException $e */
        $e = $this->throwable;

        return response()->apiError(
            messages: array_reduce($e->errors(), function (mixed $a, mixed $b) {
                return array_merge($a, $b);
            }, []),
            responseCode: Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }

    protected function authenticationError(): JsonResponse
    {
        return response()->apiError(
            responseCode: Response::HTTP_UNAUTHORIZED,
        );
    }

    protected function authorizationError(): JsonResponse
    {
        return response()->apiError(
            messages: __('exceptions/global.authorization_failed'),
            responseCode: Response::HTTP_FORBIDDEN,
        );
    }

    protected function serverError(Throwable $throwable): JsonResponse
    {
        logger()->error($throwable->getMessage(), [
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
            'trace' => $throwable->getTrace(),
        ]);

        return response()->apiError(
            messages: AppHelper::isDevMode()
                ? $throwable->getMessage()
                : __('exceptions/global.server_error'),
            responseCode: Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }

    protected function customError(Throwable $throwable): JsonResponse
    {
        return response()->apiError(
            messages: $throwable->getMessage(),
            responseCode: $throwable->getCode(),
        );
    }
}
