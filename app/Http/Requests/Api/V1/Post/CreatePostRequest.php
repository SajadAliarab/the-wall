<?php

namespace App\Http\Requests\Api\V1\Post;

use App\Contracts\Requests\HasDataTransferObjectInterface;
use App\DataTransferObject\Post\CreatePostDto;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
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

                // required attribute id
                $required = $category->attributes
                    ->where('pivot.is_require', true)
                    ->pluck('id');

                // provided attribute keys from the request
                $provided = collect($this->input('attributes', []));

                // add one error per missing attribute
                $required->diff($provided->keys())
                    ->each(fn ($id) =>
                    $validator->errors()->add('attributes', "Attribute '{$id}' is required")
                    );
                //Attributes type validation
                $category->attributes->each( function ($attribute) use ($provided, $validator) {
                    if ($provided->has($attribute->id)) {
                        $value = [$provided->get($attribute->id)];

                        $rules = [$attribute->type->validationType()];
                        $validation = validator($value , $rules);
                        if ($validation->fails()) {
                            $validator->errors()->add(
                                "attributes.{$attribute->id}",
                                "Attribute '{$attribute->name}' must be of type {$attribute->type->value}"
                            );
                        }
                    }
                });
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
