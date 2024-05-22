<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_code', 'invoice_id', 'amount'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->payment_code = self::generatePaymentCode();
        });

        self::created(function ($payment) {
            $payment->invoice->refresh(); // Refresh invoice to get the latest data
            $payment->updateInvoiceStatus();
            $payment->createPaymentReceipt();
        });
    }

    public static function generatePaymentCode()
    {
        $latestPayment = self::latest('id')->first();
        $paymentNumber = $latestPayment ? $latestPayment->id + 1 : 1;

        $month = now()->format('m');
        $year = now()->format('Y');
        $formattedPaymentNumber = str_pad($paymentNumber, 4, '0', STR_PAD_LEFT);

        return "PR/{$month}/{$year}/{$formattedPaymentNumber}";
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function receipts()
    {
        return $this->hasMany(PaymentReceipt::class);
    }

    public function createPaymentReceipt()
    {
        $paymentReceipt = $this->receipts()->create([
            'amount' => $this->amount,
        ]);

        return $paymentReceipt;
    }

    public function updateInvoiceStatus()
    {
        $totalPaid = $this->invoice->payments()->sum('amount');

        if ($totalPaid >= $this->invoice->total_amount) {
            $this->invoice->status = 'paid';
        } else {
            $this->invoice->status = 'unpaid';
        }

        $this->invoice->save();
    }
}
