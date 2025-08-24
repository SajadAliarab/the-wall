<?php

namespace App\DataTransferObject\Attachment;

use Illuminate\Http\UploadedFile;

class UploadAttachmentDto
{
    public function __construct(
        public UploadedFile $image,
    ) {}
}
