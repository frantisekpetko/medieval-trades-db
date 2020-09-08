<?php
        
namespace App\Entities;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class Category extends Entity {

    protected $table = 'categorys';

    protected $fillable = [
        'title',
        'product_count',
        'parent_id',
        'admin_id',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }


}