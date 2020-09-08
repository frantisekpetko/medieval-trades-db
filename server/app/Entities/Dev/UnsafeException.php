<?php

namespace App\Entities\Dev;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class UnsafeException extends Entity {

    protected $table = 'unsafe_exceptions';

    protected $fillable = [
        'class',
        'message',
        'created_at',
        'updated_at'
    ];




}