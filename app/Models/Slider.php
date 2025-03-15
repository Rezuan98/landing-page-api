<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'image',
        'status',
        'order'
    ];
    
    // Helper method to get full image URL
    public function getImageUrl()
    {
        return asset('storage/' . $this->image);
    }
}