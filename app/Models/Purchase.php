<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = 'purchases';
    protected $fillable = [
        'date',
        'creator_id',
        'invoice',
        'requisition_id',
        'supplier_id',
        'subtotal',
        'discount',
        'percentage',
        'discount_price',
        'vat',
        'total_amount',
        'paid_amount',
        'due_amount'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function requisition()
    {
        return $this->belongsTo(Requisition::class, 'requisition_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    
    public function purchaseProduct()
    {
        return $this->hasMany(PurchaseProduct::class, 'purchase_id', 'id');
    }
}
