<?php

namespace App\DataTransferObject\User;

class UpdateUserDto
{
    public function __construct(
        public string $name,
    ) {}

}
