<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id) {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->price;
    }

    public function redact($id, $num) {
        $num = intval($num);
        if ($num >=0 ){
            if ($this->items) {
                if (array_key_exists($id, $this->items)) {
                        $this->totalQty -= $this->items[$id]['qty'];
                        $this->totalPrice -= $this->items[$id]['price'];
                        $this->items[$id]['qty'] = $num;
                        $this->totalQty += $num;
                        $this->totalPrice += $this->items[$id]['price'];
                }
            }
        }
    }

    public function removeItem($id) {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'] * $this->items[$id]['qty'];
        unset($this->items[$id]);
    }

}
