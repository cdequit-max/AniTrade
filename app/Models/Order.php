<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'reference', 'buyer_id', 'store_id', 'produce_id', 'quantity', 'total',
        'fulfillment', 'status', 'payment_status', 'notes',
    ];

    protected function casts(): array
    {
        return ['total' => 'decimal:2'];
    }

   public function buyer(): BelongsTo
{
    return $this->belongsTo(User::class, 'buyer_id')->withDefault(['name' => 'Deleted user']);
}

public function store(): BelongsTo
{
    return $this->belongsTo(User::class, 'store_id')->withDefault(['name' => 'Deleted store']);
}

public function produce(): BelongsTo
{
    return $this->belongsTo(Produce::class)->withDefault(['name' => 'Removed produce', 'unit' => '']);
}

    /** CSS modifier for the .badge-table component. */
    public function statusBadge(): string
    {
        return match ($this->status) {
            'completed', 'confirmed' => 'success',
            'cancelled' => 'failed',
            default => 'pending',
        };
    }

    public function paymentBadge(): string
    {
        return $this->payment_status === 'paid' ? 'success' : 'pending';
    }

    public function isOpen(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'], true);
    }

    /** Return the ordered quantity to the produce stock (used on cancellation). */
    public function restock(): void
    {
        $this->produce()->increment('stock', $this->quantity);
    }
}
