<?php

namespace App\DataTransferObject\Post;

class CreatePostDto
{
    public function __construct(
        public string $title,
        public string $description,
        public float $price,
        public int $category_id,
    ) {}
}
