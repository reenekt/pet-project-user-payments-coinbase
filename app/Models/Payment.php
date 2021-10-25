<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $comment
 * @property int $user_from_id ID of user that created payment
 * @property string $status Payment status (pending, done, fail, cancelled)
 * @property string $amount Amount like "999.55"
 * @property string $currency Fiat (USD, RUB...) or crypto (BTC, DOGE...) currency
 * @property string $target_type Payment target type.
 *                               "crypto_wallet" or (not implemented) other methods like credit_card, paypal, etc
 * @property array $target Payment target (crypto wallet address or bank details for transfer)
 * @property array $target_meta Payment target meta (bank name and/or other details, or crypto payment details)
 *
 * @property-read User $user_from User that created payment
 *
 * @see \Database\Seeders\PaymentsTableSeeder class for examples
 */
class Payment extends Model
{
    use HasFactory;

    protected $casts = [
        'target' => 'array',
        'target_meta' => 'array',
    ];

    /**
     * User that created payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_from()
    {
        return $this->belongsTo(User::class, 'user_from_id', 'id');
    }
}
