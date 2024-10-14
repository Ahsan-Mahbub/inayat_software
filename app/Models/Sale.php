<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = 'sales';
    protected $fillable = [
        'date',
        'invoice',
        'challan',
        'creator_id',
        'customer_id',
        'requisition_id',
        'subtotal',
        'discount',
        'percentage',
        'discount_price',
        'vat',
        'tax',
        'ait',
        'vat_amount',
        'tax_amount',
        'ait_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'adjustment_amount',
        'payment_date',
        'payment_amount',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function requisition()
    {
        return $this->belongsTo(SaleRequisition::class, 'requisition_id');
    }
    
    public function saleProduct()
    {
        return $this->hasMany(SaleProduct::class, 'sale_id', 'id')->with('product', 'batch');
    }
    
}
