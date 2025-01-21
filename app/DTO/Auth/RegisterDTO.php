<?php

declare(strict_types=1);

namespace App\DTO\Auth;

class RegisterDTO
{
    public function __construct(
        public string $email,
        public string $name,
        public string $password,
    ) {
    }
}
