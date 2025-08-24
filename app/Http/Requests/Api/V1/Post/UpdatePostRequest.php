<?php

namespace App\Http\Requests\Api\V1\Post;

use App\Contracts\Requests\HasDataTransferObjectInterface;
use App\DataTransferObject\Post\UpdatePostDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest implements HasDataTransferObjectInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['string'],
            'description' => ['string'],
            'price' => ['numeric'],
            'user_id' => ['integer'],
            'category_id' => ['integer'],
            'images' => ['array'],
            'images.*' => ['exists:attachments,id'],
        ];
    }

    public function toDto(): UpdatePostDto
    {
        return new UpdatePostDto(
            title: $this->input('title'),
            description: $this->input('description'),
            price: $this->input('price'),
            category_id: $this->input('category_id'),
            images: $this->has('images') ? collect($this->input('images')) : null,
        );
    }
}
