<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'schedules';
    protected $fillable = [
        'date',
        'customer_id',
        'sale_id',
        'amount',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
