<?php
        
namespace App\Entities;
        
use \Illuminate\Database\Eloquent\Model as Entity;
        
class Customers extends Entity {
        
    protected $table = 'customerss';
    protected $fillable = [
         'id',
         'name',
         'work',
         'age',
         'created_at',
         'updated_at'
    ];

}