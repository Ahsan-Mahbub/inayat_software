<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';
    protected $fillable = [
        'head_id',
        'subhead_id',
        'date',
        'amount',
        'reason',
        'employee_id',
        'image',
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
}
