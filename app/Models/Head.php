<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Head extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'heads';
    protected $fillable = [
        'head_name',
    ];

    public function subheads()
    {
        return $this->hasMany(SubHead::class);
    }
}
