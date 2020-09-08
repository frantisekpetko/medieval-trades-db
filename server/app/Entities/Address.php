<?php
        
namespace App\Entities;

use \Illuminate\Database\Eloquent\Model as Entity;

class Address extends Entity {

    protected $table = 'addresss';

    protected $fillable = [
        'name',
        'street',
        'city',
        'postal_code',
        'state',
        'region',
        'telephone',
        'telephone',
    ];


    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}