<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouses extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'capacity',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'warehouse_id');
    }
}
