<?php

namespace App\Actions\Api\V1\Attribute;

use App\Models\Category;
use Illuminate\Support\Collection;

class GetAttributeByCategoryAction
{
    public function handle(Category $category): Collection
    {
        return $category->attributes()->where('category_id', $category->id)->get();

    }
}
