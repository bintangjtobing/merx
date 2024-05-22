<?php

namespace App\Models;

use App\Models\Scopes\CreatedAtDescScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'email',
        'transaction_type',
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

    public function contacts()
    {
        return $this->hasMany(VendorContact::class);
    }

    public function transactions()
    {
        return $this->hasMany(VendorTransaction::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
