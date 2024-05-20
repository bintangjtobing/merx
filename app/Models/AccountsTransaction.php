<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'date',
        'amount',
        'account_id',
    ];

    protected static function booted()
    {
        parent::boot();

        static::created(function ($transaction) {
            // Membuat JournalEntry saat AccountsTransaction baru dibuat
            JournalEntry::create([
                'account_id' => $transaction->account_id,
                'date' => $transaction->date,
                'debit' => $transaction->type === 'debit' ? $transaction->amount : 0,
                'credit' => $transaction->type === 'credit' ? $transaction->amount : 0,
                'description' => $transaction->description,
                'transaction_id' => $transaction->id,
            ]);
        });

        self::creating(function ($model) {
            $model->user_created = auth()->id();
        });

        self::updating(function ($model) {
            $model->user_updated = auth()->id();
        });
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}