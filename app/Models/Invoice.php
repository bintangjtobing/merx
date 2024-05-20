<?php

namespace App\Models;

use App\Models\Scopes\CreatedAtDescScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'total_amount',
        'paid_amount',
        'balance_due',
        'invoice_date',
        'due_date',
        'status',
    ];

    protected $appends = ['kode_invoice'];

    public function getKodeInvoiceAttribute()
    {
        if (!is_null($this->created_at)) {
            return 'INV/' . $this->created_at->format('Y') . '/' . $this->created_at->format('m') . '/' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
        }
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 'paid':
                return 'Lunas';
            case 'unpaid':
                return 'Belum Lunas';
            case 'partial':
                return 'Cicilan';
            default:
                return 'Unknown';
        }
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CreatedAtDescScope());
    }

    // Hubungan ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Hubungan ke Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}