<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'size_id',
        'quantity'
    ];
    
    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    // Relationship with Size
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    
    // Check if this size for the product is in stock
    public function isInStock()
    {
        return $this->quantity > 0;
    }
}