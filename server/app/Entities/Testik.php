<?php
        
namespace App\Entities;
        
use \Illuminate\Database\Eloquent\Model as Entity;
        
class Testik extends Entity {
        
    protected $table = 'testiks';
    protected $fillable = [
         'id',
         'name',
         'count',
         'created_at',
         'updated_at'
    ];

}