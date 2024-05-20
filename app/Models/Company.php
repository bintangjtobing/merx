<?php

namespace App\Models;

use App\Models\Scopes\CreatedAtDescScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'website',
        'logo',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'industry',
        'description',
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
    public function departments()
    {
        return $this->hasMany(CompaniesDepartment::class);
    }

    public function branches()
    {
        return $this->hasMany(CompaniesBranch::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}