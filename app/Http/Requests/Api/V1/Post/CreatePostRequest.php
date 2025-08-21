<?php

namespace App\Http\Requests\Api\V1\Post;

use App\Contracts\Requests\HasDataTransferObjectInterface;
use App\DataTransferObject\Post\CreatePostDto;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest implements HasDataTransferObjectInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'integer'],
        ];
    }

    public function toDto(): CreatePostDto
    {
        return new CreatePostDto(
            title: $this->input('title'),
            description: $this->input('description'),
            price: $this->input('price'),
            category_id: $this->input('category_id'),
        );
    }
}
