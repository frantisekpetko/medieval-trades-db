<?php
        
namespace App\Entities;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class Order extends Entity {

    protected $table = 'orders';

    protected $fillable = [
        'mail_type_order',
        'transport_type',
        'payment_type',
        'note',
        'customer_id',
        'address_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }




}