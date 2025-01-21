<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\DTO\BaseResultDTO;
use App\Models\User;

class GetUserResultDTO extends BaseResultDTO
{
    public function __construct(
        public bool $isSuccess,
        public ?string $message = null,
        public ?User $user = null
    )
    {
        parent::__construct(isSuccess: $this->isSuccess, message: $this->message);
    }
}
