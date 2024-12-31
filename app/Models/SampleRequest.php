<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleRequest extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = 'sample_requests';
    protected $fillable = [
        'date',
        'creator_id',
        'editor_id',
        'customer_id',
        'request_number',
        'status',
        'duplicate_requ',
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
        'trams_condition',
        'show_terms',
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

    public function requestProduct(){
        return $this->hasMany(SampleRequestProduct::class, 'request_id', 'id')->with('product', 'unit');
    }
}
