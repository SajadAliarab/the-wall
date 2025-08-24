<?php

namespace App\Actions\Api\V1\Attachment;

use App\DataTransferObject\Attachment\UploadAttachmentDto;
use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class UploadAttachmentAction
{
    public function handle(UploadAttachmentDto $attachmentDto): Attachment
    {
        $user = auth()->user();

        /** @var string $directory */
        $directory = $user->id;
        $fileName = time() . '-' . Str::uuid7()->toString() . '.' . $attachmentDto->image->getClientOriginalExtension();
        $filePath = $directory . '/' . $fileName;

        $originalName = $attachmentDto->image->getClientOriginalName();
        $size = $attachmentDto->image->getSize();
        $mimeType = $attachmentDto->image->getMimeType();

        DB::beginTransaction();

        try {
            $attachment = new Attachment;
            $attachment->disk = config('filesystems.default');
            $attachment->path = $filePath;
            $attachment->original_name = $originalName;
            $attachment->size = $size;
            $attachment->mime_type = $mimeType;
            $attachment->save();

            Storage::putFileAs($directory, $attachmentDto->image, $fileName);

        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        DB::commit();

        return $attachment;
    }
}
