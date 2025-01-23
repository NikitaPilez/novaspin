<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read integer $id
 * @property string $code
 * @property float $amount
 * @property string $valid_from
 * @property string $valid_until
 * @property string $max_activations
 * @property string $is_unlimited
 *
 */
class PromoCode extends Model
{
    protected $fillable = [
        'code', 'amount', 'valid_from', 'valid_until', 'max_activations', 'is_unlimited',
    ];

    public function activations(): HasMany
    {
        return $this->hasMany(PromoCodeActivation::class);
    }

    public function isExpired(): bool
    {
        return $this->valid_until && now()->gt($this->valid_until);
    }

    public function hasReachedActivationLimit(): bool
    {
        return !$this->is_unlimited && $this->activations()->count() >= $this->max_activations;
    }
}
