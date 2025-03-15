<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'question',
        'answer',
        'status',
        'order'
    ];
    
    // Scope for active FAQs
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
    
    // Scope for ordered FAQs
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}