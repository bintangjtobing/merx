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
        'description',
    ];

    protected static function booted()
    {
        static::created(function ($transaction) {
            // Creating a JournalEntry when a new AccountsTransaction is created
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