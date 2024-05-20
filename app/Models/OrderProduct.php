<?php

namespace App\Models;

use App\Models\Scopes\CreatedAtDescScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'price_per_unit',
        'total_price',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CreatedAtDescScope());
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Ensure this is 'product_id'
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id'); // Ensure this is 'order_id'
    }
}