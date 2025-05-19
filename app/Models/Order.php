<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

     protected $casts = [
        'created_at' => 'datetime',
    ];
   protected $fillable = [
        'customer_name',
        'customer_email',
        
    ];
    public function items()
{
    return $this->hasMany(OrderItem::class);
}
  public function orderitems()
{
    return $this->hasMany(OrderItem::class);
}

// Accessors
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

    public function getGrandTotalAttribute()
    {
        return $this->subtotal;
    }

}
