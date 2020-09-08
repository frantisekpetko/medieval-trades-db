<?php
        
namespace App\Entities;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class OrderProduct extends Entity {

    protected $table = 'order_products';
    protected $fillable = [
        'quantity',
        'product_id',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}