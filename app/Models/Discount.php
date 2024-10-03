<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'discounts';
    protected $fillable = [
        'user_id',
        'discount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
