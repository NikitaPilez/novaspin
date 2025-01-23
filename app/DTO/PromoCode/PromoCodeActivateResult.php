<?php

declare(strict_types=1);

namespace App\DTO\PromoCode;

use App\DTO\BaseResultDTO;

class PromoCodeActivateResult extends BaseResultDTO
{
    public function __construct(
        public bool $isSuccess,
        public ?string $message = null,
    ) {
        parent::__construct(isSuccess: $this->isSuccess, message: $this->message);
    }
}
