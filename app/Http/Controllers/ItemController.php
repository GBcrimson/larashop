<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Auth;

class ItemController extends Controller
{
    public function getItem(Request $request, $id)
    {
        $product = Product::find($id);
        return view('shop.index', ['products' => $products]);
    }

    public function postItem(Request $request, $id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        if(!$request->ajax())
            return redirect()->route('product.index');
    }

    public function putItem(Request $request, $id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->redact($id, $request->all()["num"]);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        if(!$request->ajax())
            return redirect()->route('product.shoppingCart');
        else
            return response()->json($cart);
    }

    public function deleteItem(Request $request, $id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return response()->json($cart);
    }
}
