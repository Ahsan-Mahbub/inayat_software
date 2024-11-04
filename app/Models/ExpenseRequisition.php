<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRequisition extends Model
{
    use HasFactory;

    protected $table = 'expense_requisitions';
    protected $fillable = [
        'head_id',
        'subhead_id',
        'date',
        'request_amount',
        'amount',
        'reason',
        'employee_id',
        'accessor_id',
        'requisition',
        'status'
    ];

    public function head()
    {
        return $this->belongsTo(Head::class, 'head_id');
    }

    public function subHead()
    {
        return $this->belongsTo(SubHead::class, 'subhead_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function accessor()
    {
        return $this->belongsTo(User::class, 'accessor_id');
    }
}
