<?php
namespace App\Models;

use App\Models\Scopes\CreatedAtDescScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendors_id',
        'amount',
        'product_id',
        'unit_price',
        'total_price',
        'taxes',
        'shipping_cost',
        'order_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CreatedAtDescScope());

        self::creating(function ($model) {
            $model->user_created = auth()->id();
        });

        self::updating(function ($model) {
            $model->user_updated = auth()->id();
        });
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendors_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
