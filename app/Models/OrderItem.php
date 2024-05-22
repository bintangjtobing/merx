<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($orderItem) {
            $orderItem->calculateTotalPrice();
        });

        self::updating(function ($orderItem) {
            $orderItem->calculateTotalPrice();
        });

        self::deleting(function ($orderItem) {
            $orderItem->order->calculateTotalAmountFrontend();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function calculateTotalPrice()
    {
        $this->total_price = $this->quantity * $this->price;
    }

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getProductAttribute()
    {
        return $this->product()->first();
    }
}