<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function watt()
    {
        return $this->belongsTo(Watt::class, 'watt_id');
    }

    public function temperature()
    {
        return $this->belongsTo(Temperature::class, 'temperature_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

}
