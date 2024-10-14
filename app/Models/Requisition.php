<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = 'requisitions';
    protected $fillable = [
        'date',
        'requisition_number',
        'creator_id',
        'editor_id',
        'supplier_id',
        'subtotal',
        'discount',
        'percentage',
        'discount_price',
        'vat',
        'total_amount',
        'status',
        'duplicate_requ',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    
    public function requisitionProduct(){
        return $this->hasMany(RequisitionProduct::class, 'requisition_id', 'id')->with('product','unit');
    }
}
