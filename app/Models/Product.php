<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'sku',
        'category_id',
        'purchase_price',
        'sale_price',
        'image',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function purchaseProduct()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    public function purchaseReturn()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function saleProduct()
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function saleReturn()
    {
        return $this->hasMany(SaleReturn::class);
    }
}
