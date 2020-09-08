<?php
        
namespace App\Entities;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class Image extends Entity {

    protected $table = 'images';

    protected $fillable = [
        'img_name',
        'img_path',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}