<?php

namespace App\DataTransferObject\Post;

use Illuminate\Support\Collection;

class CreatePostDto
{
    public function __construct(
        public string $title,
        public string $description,
        public float $price,
        public int $category_id,
        public Collection $images,
    ) {}
}
