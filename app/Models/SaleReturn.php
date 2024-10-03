<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;

    protected $table = 'sale_returns';
    protected $fillable = [
        'date',
        'sale_id',
        'customer_id',
        'product_id',
        'unit_id',
        'sale_product_id',
        'qty',
        'amount',
        'return_per_profit'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
