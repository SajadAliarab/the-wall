<?php

namespace App\Actions\Api\V1\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class GetCategoryListAction
{
    public function handle(): Collection
    {
        return Category::query()
            ->hasNoParent()
            ->get();
    }
}
