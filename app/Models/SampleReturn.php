<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleReturn extends Model
{
    use HasFactory;

    protected $table = 'sample_returns';
    protected $fillable = [
        'date',
        'creator_id',
        'request_id',
        'customer_id',
        'product_id',
        'unit_id',
        'request_product_id',
        'qty',
        'amount'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function request()
    {
        return $this->belongsTo(SampleRequest::class, 'request_id');
    }

    public function sampleRequest()
    {
        return $this->belongsTo(SampleRequest::class, 'request_id');
    }
}
