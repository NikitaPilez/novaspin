<?php

declare(strict_types=1);

namespace App\Contracts\PromoCode;

use App\DTO\PromoCode\PromoCodeActivateResult;

interface PromoCodeContract
{
    public function activate(int $userId, string $code): PromoCodeActivateResult;
}
