<?php

namespace App\Http\Requests\Api\V1\User;

use App\Contracts\Requests\HasDataTransferObjectInterface;
use App\DataTransferObject\User\UpdateUserDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest implements HasDataTransferObjectInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    public function toDto(): UpdateUserDto
    {
        return new UpdateUserDto(
            name: $this->input('name'),
        );

    }
}
