<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'phone',
        'address',
        'city',
        'shipping_option',
        'subtotal',
        'shipping_cost',
        'total',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Scope a query to filter by status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    /**
     * Get the status badge HTML.
     */
    public function getStatusBadgeAttribute()
    {
        $statusClass = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger'
        ];
        
        $class = $statusClass[$this->status] ?? 'secondary';
        
        return '<span class="badge bg-' . $class . '">' . ucfirst($this->status) . '</span>';
    }
}