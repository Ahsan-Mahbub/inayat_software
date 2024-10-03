<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionProduct extends Model
{
    use HasFactory;

    protected $table = 'requisition_products';
    protected $fillable = [
        'requisition_id',
        'product_id',
        'unit_id',
        'purchase_price',
        'sale_price',
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

    public function requisition()
    {
        return $this->belongsTo(Requisition::class, 'requisition_id');
    }
}
