<?php
        
namespace App\Entities;
        
use \Illuminate\Database\Eloquent\Model as Entity;
        
class Test extends Entity {
        
    protected $table = 'tests';
    protected $fillable = [
         'id',
         'name',
         'count',
         'created_at',
         'updated_at'
    ];

}