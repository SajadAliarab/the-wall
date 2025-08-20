<?php

use App\Http\Controllers\Api\V1\Auth\CreateTokenController;
use App\Http\Controllers\Api\V1\User\UpdateUserController;

Route::name('api.')
    ->group(function () {
        // V1 routes
        Route::name('v1.')
            ->prefix('v1')
            ->group(function () {

                Route::name('auth.')
                    ->prefix('auth')
                    ->group(function () {
                        Route::post('token', CreateTokenController::class)->name('create-token');
                    });
                Route::name('users.')
                    ->prefix('users')
                    ->group(function () {
                        Route::middleware('auth:sanctum')->group(function () {
                            Route::put('update', UpdateUserController::class)->name('update');
                        });
                    });

            });
    });
