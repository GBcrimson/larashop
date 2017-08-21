<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['comment', 'amount', 'user_id', 'cart', 'address', 'name', 'price', 'phone'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
