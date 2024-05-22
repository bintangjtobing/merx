<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'order_id',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->invoice_code = self::generateInvoiceCode();
            $model->status = 'unpaid';
            $model->calculateTotalAmount();
        });
    }

    public static function generateInvoiceCode()
    {
        $latestInvoice = self::latest('id')->first();
        $invoiceNumber = $latestInvoice ? $latestInvoice->id + 1 : 1;

        $month = now()->format('m');
        $year = now()->format('Y');
        $formattedInvoiceNumber = str_pad($invoiceNumber, 4, '0', STR_PAD_LEFT);

        return "INV/{$month}/{$year}/{$formattedInvoiceNumber}";
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function calculateTotalAmount()
    {
        // Calculate total_amount based on OrderItem prices
        $orderItems = OrderItem::where('order_id', $this->order_id)->get();
        $totalAmount = $orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->total_amount = $totalAmount;
    }
}
