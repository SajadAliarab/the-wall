<?php

namespace App\DataTransferObject\Post;

use Illuminate\Support\Collection;

class UpdatePostDto
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?float $price = null,
        public ?int $category_id = null,
        public ?Collection $images = null,
    ) {}

}
