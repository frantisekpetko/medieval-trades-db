<?php
        
namespace App\Entities;

use \Illuminate\Database\Eloquent\Model as Entity;
        
class Product extends Entity {

    protected $table = 'products';

    protected $fillable = [
        'name',
        'title',
        'description',
        'stock_quantity',
        'price',
        'price_vat',
        'vat',
        'discount',
        'admin_id',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    public function image()
    {
        return $this->hasMany(Image::class);
    }

}