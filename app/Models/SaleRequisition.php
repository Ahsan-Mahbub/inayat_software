<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleRequisition extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = 'sale_requisitions';
    protected $fillable = [
        'date',
        'creator_id',
        'customer_id',
        'requisition_number',
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
        'status',
        'trams_condition',
        'show_terms',
        'duplicate_requ',
        'editor_id',
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function requisitionProduct(){
        return $this->hasMany(SaleRequisitionProduct::class, 'requisition_id', 'id')->with('product', 'unit');
    }
}
