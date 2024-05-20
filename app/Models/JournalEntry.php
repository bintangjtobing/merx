<?php

namespace App\Models;

use App\Models\Scopes\CreatedAtDescScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'date',
        'debit',
        'credit',
        'description',
        'transaction_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CreatedAtDescScope());
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transaction()
    {
        return $this->belongsTo(AccountsTransaction::class, 'transaction_id');
    }
}