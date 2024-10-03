<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'customers';
    protected $fillable = [
        'creator_id',
        'customer_id',
        'customer_name',
        'phone',
        'email',
        'address',
        'designation',
        'company_name',
        'delivery_address',
        'image',
        'total_amount',
        'paid_amount',
        'return_amount'
    ];
}
