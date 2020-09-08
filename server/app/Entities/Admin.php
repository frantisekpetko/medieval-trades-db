<?php
        
namespace App\Entities;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class Admin extends Entity {

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'url_hash',
        'auth_status',
        'banned_at',
        'telephone',
    ];

    public function category()
    {
        return $this->hasMany(Category::class);
    }

}