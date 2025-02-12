<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'accounts';
    protected $fillable = [
        'method_id',
        'account_name',
        'details',
        'total_amount',
        'current_amount',
    ];

    public function method()
    {
        return $this->belongsTo(Method::class, 'method_id');
    }
}
