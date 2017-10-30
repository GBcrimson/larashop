<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'description', 'price', 'category', 'subcategory'];
    public function photos() {
        return $this->hasMany('App\ProductsPhoto');
    }
}
