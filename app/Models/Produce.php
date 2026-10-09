<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produce extends Model
{
    use HasFactory;

    public const CATEGORIES = ['Vegetables', 'Fruits', 'Grains', 'Root Crops', 'Others'];

    public const UNITS = ['kg', 'piece', 'bundle', 'sack'];

    protected $fillable = ['store_id', 'name', 'category', 'price', 'unit', 'stock', 'description'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(User::class, 'store_id');
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }
}
