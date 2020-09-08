<?php

namespace App\Entities\Dev;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class ServerException extends Entity {

    protected $table = 'server_exceptions';

    protected $fillable = [
         'type',
         'message',
         'class',
         'current',
         'total',
         'created_at',
         'updated_at'
    ];


}