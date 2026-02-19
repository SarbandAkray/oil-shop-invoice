<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'number', 'date', 'customer_name', 'address', 'phone',
        'tax', 'paid', 'notes', 'currency',
    ];

    protected $casts = [
        'date' => 'date',
        'tax'  => 'float',
        'paid' => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function subtotal(): float
    {
        return $this->items->sum(fn($item) => $item->quantity * $item->unit_price);
    }

    public function grandTotal(): float
    {
        return $this->subtotal() + $this->tax;
    }

    public function remaining(): float
    {
        return $this->grandTotal() - $this->paid;
    }
}
