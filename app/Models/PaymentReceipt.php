<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id', 'amount'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}