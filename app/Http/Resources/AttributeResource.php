<?php

namespace App\Http\Resources;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Attribute */
class AttributeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $attribute = $this->resource;

        return [
            'id' => $attribute->id,
            'name' => $attribute->name,
            'type' => $attribute->type,
            'value' => $this->whenPivotLoaded('post_attributes', fn (): mixed => $attribute->pivot->value),
        ];
    }
}
