<?php

namespace App\Http\Requests\Api\V1\Post;

use App\Contracts\Requests\HasDataTransferObjectInterface;
use App\DataTransferObject\Post\CreatePostDto;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

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
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'images' => ['required', 'array'],
            'images.*' => ['required', 'exists:attachments,id'],
            'attributes' => ['required', 'array'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $category = Category::query()->find($this->input('category_id'));

                if (! $category) {
                    $validator->errors()->add('category_id', 'Invalid category.');
                    return;
                }

                // required attribute names (lowercased, unique)
                $required = $category->attributes
                    ->pluck('name')
                    ->filter()
                    ->map(fn ($n) => Str::lower($n))
                    ->unique();

                // provided attribute keys from the request (lowercased, unique)
                $provided = collect($this->input('attributes', []))
                    ->keys()
                    ->map(fn ($n) => Str::lower($n))
                    ->unique();

                // add one error per missing attribute
                $required->diff($provided)
                    ->each(fn ($name) =>
                    $validator->errors()->add('attributes', "Attribute '{$name}' is required")
                );
            },
        ];
    }


    public function toDto(): CreatePostDto
    {
        return new CreatePostDto(
            title: $this->input('title'),
            description: $this->input('description'),
            price: $this->input('price'),
            category_id: $this->input('category_id'),
            images: collect($this->input('images')),
            attributes: collect($this->input('attributes')),
        );
    }
}
