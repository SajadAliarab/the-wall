<?php

use App\Http\Controllers\Api\V1\Attachment\UploadAttachmentController;
use App\Http\Controllers\Api\V1\Auth\CreateTokenController;
use App\Http\Controllers\Api\V1\Category\GetCategoryListController;
use App\Http\Controllers\Api\V1\Post\CreatePostController;
use App\Http\Controllers\Api\V1\Post\DeletePostController;
use App\Http\Controllers\Api\V1\Post\GetPostListController;
use App\Http\Controllers\Api\V1\Post\UpdatePostController;
use App\Http\Controllers\Api\V1\User\CreateUserController;
use App\Http\Controllers\Api\V1\User\UpdateUserController;

Route::name('api.')
    ->group(function () {
        // V1 routes
        Route::name('v1.')
            ->prefix('v1')
            ->group(function () {

                // Auth
                Route::name('auth.')
                    ->prefix('auth')
                    ->group(function () {
                        Route::post('token', CreateTokenController::class)->name('create-token');
                    });

                // Users
                Route::name('users.')
                    ->prefix('users')
                    ->group(function () {
                        Route::post('/', CreateUserController::class)->name('create');

                        Route::middleware('auth:sanctum')->group(function () {
                            Route::put('/', UpdateUserController::class)->name('update');
                        });
                    });

                // Categories
                Route::name('categories.')
                    ->prefix('categories')
                    ->group(function () {
                        Route::get('/', GetCategoryListController::class)->name('list');
                    });

                // Posts
                Route::name('posts.')
                    ->prefix('posts')
                    ->group(function () {
                        Route::get('/', GetPostListController::class)->name('list');
                        Route::middleware('auth:sanctum')->group(function () {
                            Route::post('/', CreatePostController::class)->name('create');
                            Route::put('/{post}', UpdatePostController::class)->name('update');
                            Route::delete('/{post}', DeletePostController::class)->name('delete');
                        });
                    });

                // Attachments
                Route::name('attachments.')
                    ->prefix('attachments')
                    ->group(function () {
                        Route::middleware('auth:sanctum')->group(function () {
                            Route::post('/', UploadAttachmentController::class)->name('upload');
                        });
                    });

            });
    });
