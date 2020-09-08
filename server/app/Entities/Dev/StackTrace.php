<?php
        
namespace App\Entities\Dev;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class StackTrace extends Entity {

    protected $table = 'stack_traces';

    protected $fillable = [
        'namespace',
        'short_class',
        'class',
        'type',
        'function',
        'file',
        'line',
        'created_at',
        'updated_at'
    ];

}