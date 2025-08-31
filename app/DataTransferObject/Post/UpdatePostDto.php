<?php

namespace App\DataTransferObject\Post;

use Illuminate\Support\Collection;

class UpdatePostDto
{
    public function __construct(
        public string $title,
        public string $description,
        public float $price,
        public int $category_id,
        public Collection $images,
        public Collection $attributes,
    ) {}

}
