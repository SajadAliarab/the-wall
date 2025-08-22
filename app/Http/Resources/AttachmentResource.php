<?php

namespace App\Http\Resources;

use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Post */
class AttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Attachment $attachment */
        $attachment = $this->resource;

        return [
            'id' => $attachment->id,
            'url' => $attachment->url(),
        ];
    }
}
