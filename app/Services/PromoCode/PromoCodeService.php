<?php

declare(strict_types=1);

namespace App\Services\PromoCode;

use App\Contracts\PromoCode\PromoCodeContract;
use App\Models\PromoCode;
use App\Models\User;
use \App\DTO\PromoCode\PromoCodeActivateResult;
use Illuminate\Support\Facades\DB;

class PromoCodeService implements PromoCodeContract
{
    public function activate(int $userId, string $code): PromoCodeActivateResult
    {
        return DB::transaction(function () use ($userId, $code) {
            $promoCode = PromoCode::query()->where('code', $code)
                ->lockForUpdate()
                ->first();

            if (!$promoCode) {
                return new PromoCodeActivateResult(isSuccess: true, message: 'Not found');
            }

            if ($promoCode->isExpired()) {
                return new PromoCodeActivateResult(isSuccess: true, message: 'Expired');
            }

            if ($promoCode->hasReachedActivationLimit()) {
                return new PromoCodeActivateResult(isSuccess: true, message: 'Activation limit');
            }

            if ($this->isAlreadyActivated($userId, $promoCode)) {
                return new PromoCodeActivateResult(isSuccess: true, message: 'Already activate');
            }

            $promoCode->activations()->create(['user_id' => $userId]);

            $user = User::query()->where('id', $userId)->lockForUpdate()->first();
            $user->balance += $promoCode->amount;
            $user->save();

            return new PromoCodeActivateResult(isSuccess: true);
        }, 3);
    }

    protected function isAlreadyActivated(int $userId, PromoCode $promoCode): bool
    {
        return $promoCode->activations()->where('user_id', $userId)->exists();
    }
}
