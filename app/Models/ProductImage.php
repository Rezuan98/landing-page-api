<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary'
    ];
    
    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    // Helper method to get full image URL
    public function getImageUrl()
    {
        return asset('storage/' . $this->image_path);
    }
}