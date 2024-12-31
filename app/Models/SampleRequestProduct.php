<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleRequestProduct extends Model
{
    use HasFactory;

    protected $table = 'sample_request_products';
    protected $fillable = [
        'request_id',
        'product_id',
        'des_show',
        'description',
        'unit_id',
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

    public function request()
    {
        return $this->belongsTo(SampleRequest::class, 'request_id');
    }

    public function sampleReturn()
    {
        return $this->hasMany(SampleReturn::class, 'request_product_id');
    }

    public function sampleRequest()
    {
        return $this->belongsTo(SampleRequest::class, 'request_id');
    }
}
