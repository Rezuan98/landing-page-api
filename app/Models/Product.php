<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'brand_id',
        'featured',
        'status'
    ];
    
    // Relationship with Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    // Relationship with ProductSize (for sizes and quantities)
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }
    
    // Relationship with ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
    // Helper method to check if product is on sale
    public function isOnSale()
    {
        return $this->discount_price !== null && $this->discount_price > 0 && $this->discount_price < $this->price;
    }
    
    // Get total stock quantity across all sizes
    public function getTotalStock()
    {
        return $this->productSizes->sum('quantity');
    }
    
    // Check if product is in stock
    public function isInStock()
    {
        return $this->getTotalStock() > 0;
    }
    
    // Get all sizes with stock
    public function getAvailableSizes()
    {
        return $this->productSizes()->where('quantity', '>', 0)->get();
    }
}