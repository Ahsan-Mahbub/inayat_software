<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'purchase_transactions';
    protected $fillable = [
        'date',
        'supplier_id',
        'method_id',
        'account_id',
        'amount',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
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
