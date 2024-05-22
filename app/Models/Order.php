<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order_code = self::generateOrderCode();
            $model->status = 'pending';
        });
    }

    public static function generateOrderCode()
    {
        $latestOrder = self::latest('id')->first();
        $orderNumber = $latestOrder ? $latestOrder->id + 1 : 1;

        $month = now()->format('m');
        $year = now()->format('Y');
        $formattedOrderNumber = str_pad($orderNumber, 4, '0', STR_PAD_LEFT);

        return "ORD/{$month}/{$year}/{$formattedOrderNumber}";
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price', 'total_price')
                    ->withTimestamps();
    }
    public function getOrderCodeAttribute()
    {
        return $this->attributes['order_code'];
    }
}