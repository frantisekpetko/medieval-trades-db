<?php

namespace App\Entities\Dev;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class ClientError extends Entity {

    protected $table = 'client_errors';

    protected $fillable = [
         'type',
         'message',
         'stack_trace',
         'created_at',
         'updated_at'
    ];


}