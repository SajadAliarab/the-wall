<?php

namespace App\DataTransferObject\Auth;

readonly class CreateTokenDto
{
    public function __construct(
        public string $email,
        public string $password,
        public string $deviceName,
    ) {}
}
