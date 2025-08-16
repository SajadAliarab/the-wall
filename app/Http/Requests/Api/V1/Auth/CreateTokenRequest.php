<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Contracts\Requests\HasDataTransferObjectInterface;
use App\DataTransferObject\Auth\CreateTokenDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateTokenRequest extends FormRequest implements HasDataTransferObjectInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string'],
        ];
    }

    public function toDto(): CreateTokenDto
    {
        return new CreateTokenDto(
            email: $this->input('email'),
            password: $this->input('password'),
            deviceName: $this->input('device_name'),
        );
    }
}
