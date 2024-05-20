<?php

namespace App\Models;

use App\Models\Scopes\CreatedAtDescScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'warehouse_id',
        'status',
        'details',
        'total_price',
        'taxes',
        'shipping_cost',
        'no_ref',
    ];

    protected $appends = ['kode_order'];

    public function getKodeOrderAttribute()
    {
        $prefix = $this->vendor && $this->vendor->transaction_type ?
            ($this->vendor->transaction_type == 'customer' ? 'PO' : 'SO') : 'ORD';

        return $prefix . '/' . ($this->created_at ? $this->created_at->format('Y/m') . '/' . str_pad($this->id, 4, '0', STR_PAD_LEFT) : 'unknown_date/' . str_pad($this->id, 4, '0', STR_PAD_LEFT));
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouses::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function vendorTransaction()
    {
        return $this->hasOne(VendorTransaction::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
                    ->withPivot('quantity', 'price_per_unit', 'total_price')
                    ->withTimestamps();
    }

    public function calculateTotalPrice()
    {
        return $this->products->sum(fn($product) => $product->pivot->quantity * $product->pivot->price_per_unit) + ($this->taxes ?? 0) + ($this->shipping_cost ?? 0);
    }

    protected static function boot()
{
    parent::boot();
    static::addGlobalScope(new CreatedAtDescScope());
    static::saving(function ($order) {
        if ($order->products->isNotEmpty()) {
            $totalPrice = $order->products->reduce(fn($carry, $product) => $carry + ($product->pivot->quantity * $product->pivot->price_per_unit), 0);
            $order->total_price = $totalPrice + ($order->taxes ?? 0) + ($order->shipping_cost ?? 0);
        }
    });
}

    public function createInvoice()
    {
        $totalAmount = $this->total_price;
        $invoice = $this->invoices()->create([
            'total_amount' => $totalAmount,
            'balance_due' => $totalAmount,
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'status' => 'unpaid',
        ]);

        $transactionType = $this->vendor->transaction_type === 'customer' ? 'credit' : 'debit';
        $accountId = $this->determineAccountId($transactionType);

        $description = "Invoice #{$invoice->id} created based on order #{$this->kode_order}";
        AccountsTransaction::create([
            'account_id' => $accountId,
            'date' => now(),
            'type' => $transactionType,
            'amount' => $invoice->total_amount,
            'description' => $description,
        ]);

        if ($transactionType === 'credit') {
            $accountsReceivable = Account::firstOrCreate(['name' => 'Piutang Usaha']);
            $accountsReceivable->balance += $invoice->total_amount;
            $accountsReceivable->save();
        } elseif ($transactionType === 'debit') {
            $cashOrBankAccount = Account::firstOrCreate(['name' => 'Kas']);
            $cashOrBankAccount->balance -= $invoice->total_amount;
            $cashOrBankAccount->save();
        }

        return $invoice;
    }

    protected function determineAccountId(string $transactionType): ?int
    {
        $account = $transactionType === 'credit' ? Account::firstOrCreate(['name' => 'Piutang Usaha']) : Account::firstOrCreate(['name' => 'Kas']);
        return $account ? $account->id : null;
    }
}
