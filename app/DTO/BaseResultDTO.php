<?php

declare(strict_types=1);

namespace App\DTO;

class BaseResultDTO
{
    public function __construct(
        public bool $isSuccess,
        public ?string $message = null
    ) {
    }
}
