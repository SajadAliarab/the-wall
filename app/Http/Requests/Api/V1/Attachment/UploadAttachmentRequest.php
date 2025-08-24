<?php

namespace App\Http\Requests\Api\V1\Attachment;

use App\Contracts\Requests\HasDataTransferObjectInterface;
use App\DataTransferObject\Attachment\UploadAttachmentDto;
use Illuminate\Foundation\Http\FormRequest;

class UploadAttachmentRequest extends FormRequest implements HasDataTransferObjectInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ];
    }

    public function toDto(): UploadAttachmentDto
    {
        return new UploadAttachmentDto(
            image: $this->file('image'),
        );
    }
}
