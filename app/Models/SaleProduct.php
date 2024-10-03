<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    use HasFactory;
    protected $table = 'sale_products';
    protected $fillable = [
        'date',
        'sale_id',
        'batch_id',
        'product_id',
        'unit_id',
        'qty',
        'purchase_price',
        'amount',
        'discount_amount',
        'profit',
        'total_profit_amount',
        'per_profit_amount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function batch()
    {
        return $this->belongsTo(PurchaseProduct::class, 'batch_id');
    }

    public function saleReturn()
    {
        return $this->hasMany(SaleReturn::class, 'sale_product_id');
    }
}
