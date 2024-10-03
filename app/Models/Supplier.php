<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'suppliers';
    protected $fillable = [
        'supplier_id',
        'supplier_name',
        'phone',
        'email',
        'designation',
        'company_name',
        'address',
        'image',
        'total_amount',
        'paid_amount',
        'return_amount',
    ];
}
