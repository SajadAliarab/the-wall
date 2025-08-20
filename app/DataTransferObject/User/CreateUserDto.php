<?php

namespace App\DataTransferObject\User;

class CreateUserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
