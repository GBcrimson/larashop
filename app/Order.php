<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array|string address
 * @property string cart
 * @property array|string name
 * @property array|string phone
 * @property int amount
 попробуй удалить эти строки и посмотри на ошибки в продуктконтроллере
 */
class Order extends Model
{
    protected $fillable = ['comment', 'amount', 'user_id', 'cart', 'address', 'name', 'price', 'phone'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
