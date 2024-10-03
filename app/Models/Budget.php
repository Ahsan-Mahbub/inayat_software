<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';
    protected $fillable = [
        'method_id',
        'account_id',
        'date',
        'amount',
        'purpose',
        'employee_id',
    ];

    public function method()
    {
        return $this->belongsTo(Method::class, 'method_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
