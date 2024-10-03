<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    use HasFactory;
    protected $table = 'purchase_products';
    protected $fillable = [
        'purchase_id',
        'product_id',
        'unit_id',
        'qty',
        'amount',
        'discount_amount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function purchaseReturn()
    {
        return $this->hasMany(PurchaseReturn::class, 'purchase_product_id');
    }
}
