<?php
        
namespace App\Entities;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class Customer extends Entity {

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'auth_status',
        'banned_at',
        'address_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }


}