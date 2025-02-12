<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watt extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'watts';
    protected $fillable = [
        'watt_name',
    ];
}
