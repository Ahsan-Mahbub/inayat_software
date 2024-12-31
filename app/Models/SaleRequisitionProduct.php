<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleRequisitionProduct extends Model
{
    use HasFactory;

    protected $table = 'sale_requisition_products';
    protected $fillable = [
        'requisition_id',
        'product_id',
        'des_show',
        'description',
        'unit_id',
        'purchase_price',
        'sale_price',
        'qty',
        'amount',
        'discount_amount',
        'batch_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function batch()
    {
        return $this->belongsTo(PurchaseProduct::class, 'batch_id');
    }

    public function requisition()
    {
        return $this->belongsTo(SaleRequisition::class, 'requisition_id');
    }
}
