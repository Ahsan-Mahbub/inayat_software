<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubHead extends Model
{
    use HasFactory;

    protected $table = 'sub_heads';
    protected $fillable = [
        'head_id',
        'subhead_name',
    ];

    public function head()
    {
        return $this->belongsTo(Head::class, 'head_id');
    }
}
