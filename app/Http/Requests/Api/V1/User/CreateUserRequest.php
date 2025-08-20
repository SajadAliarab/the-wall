<?php

namespace App\Http\Requests\Api\V1\User;

use App\Contracts\Requests\HasDataTransferObjectInterface;
use App\DataTransferObject\User\CreateUserDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest implements HasDataTransferObjectInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'max:254', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'confirmed',
                password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ];
    }

    public function toDto(): CreateUserDto
    {
        return new CreateUserDto(
            name: $this->input('name'),
            email: $this->input('email'),
            password: $this->input('password'),
        );
    }
}
