<?php

namespace App\Models;

use App\Models\Scopes\CreatedAtDescScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'image_product', 'price',
        'type', 'subtype', 'size', 'color', 'brand', 'model', 'sku',
        'stock', 'image', 'video', 'raw_material', 'unit_of_measure',
        'warehouse_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CreatedAtDescScope());

        self::creating(function ($model) {
            $model->user_created = Auth::id();
            $model->user_updated = Auth::id();

            // Generate a unique product code
            $uniqueIdentifier = uniqid();
            $model->code = 'PRD' . strtoupper(substr(md5($uniqueIdentifier), 0, 6));
        });

        self::updating(function ($model) {
            $model->user_updated = Auth::id();
        });
    }

    public function getImageProductAttribute($image_product)
    {
        return $image_product ?: 'https://res.cloudinary.com/boxity-id/image/upload/v1709745192/39b09e1f-0446-4f78-bbf1-6d52d4e7e4df.png';
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouses::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
                    ->withPivot('quantity', 'price_per_unit', 'total_price')
                    ->withTimestamps();
    }
}
