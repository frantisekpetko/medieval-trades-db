<?php

namespace App\Entities\Dev;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class Argument extends Entity {

    protected $table = 'arguments';

    protected $fillable = [
         'type',
         'class',
         'created_at',
         'updated_at'
    ];


}