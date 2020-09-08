<?php
        
namespace App\Entities;
        
use \Illuminate\Database\Eloquent\Model as Entity;
        
class MedievalTrade extends Entity {
        
    protected $table = 'medieval_trades';
    protected $fillable = [
         'id',
         'name',
         'description',
         'url',
         'imageUrl',
         'created_at',
         'updated_at'
    ];

}