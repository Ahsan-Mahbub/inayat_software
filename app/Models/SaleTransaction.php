<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleTransaction extends Model
{
    use HasFactory;
    
    protected $primaryKey = "id";
    protected $table = 'sale_transactions';
    protected $fillable = [
        'date',
        'customer_id',
        'sale_id',
        'method_id',
        'account_id',
        'amount',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function sale()
    {
        return $this->belongsTo(sale::class, 'sale_id');
    }

    public function method()
    {
        return $this->belongsTo(Method::class, 'method_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
