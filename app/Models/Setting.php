<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = 'settings';
    protected $fillable = [
        'company_name',
        'company_title',
        'logo',
        'phone',
        'email',
        'address',
        'trams_condition',
        'purchase_trams_condition',
        'sample_trams'
    ];
}
