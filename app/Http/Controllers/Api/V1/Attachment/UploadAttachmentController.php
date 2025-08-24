<?php

namespace App\Http\Controllers\Api\V1\Attachment;

use App\Actions\Api\V1\Attachment\UploadAttachmentAction;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\Attachment\UploadAttachmentRequest;
use App\Http\Resources\AttachmentResource;
use Symfony\Component\HttpFoundation\Response;

class UploadAttachmentController extends ApiBaseController
{
    public function __invoke(UploadAttachmentRequest $request, UploadAttachmentAction $action): Response
    {
        $attachment = $action->handle($request->toDto());

        return response()->apiSuccess(
            data: new AttachmentResource($attachment),
            messages: 'Attachment uploaded successfully.',
            responseCode: Response::HTTP_CREATED
        );
    }
}
