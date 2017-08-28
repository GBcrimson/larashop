<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Auth;


class ProductController extends Controller
{
    public function getIndex()
    {
        $products = Product::all();
        return view('shop.index', ['products' => $products]);
    }

    public function getColors()
    {
        $products = Product::where('category','colors') -> get();
        return view('shop.index', ['products' => $products]);
    }

    public function getColorInstruments()
    {
        $products = Product::where('category',2) -> get();
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

    public function getCart(Request $request)
    {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        if(!$request->ajax())
            return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
        else
            return response()->json($cart);

    }

    public function getCheckout()
    {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('shop.checkout', ['total' => $total]);
    }

    public function postCheckout(Request $request)
    {
        if (!Session::has('cart')) {
            return redirect()->route('shop.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $order = new Order();
        $order->cart = serialize($cart);
        $order->address = $request->input('address');
        $order->name = $request->input('name');
        $order->amount = $cart->totalPrice;

        Auth::user()->orders()->save($order);

        Session::forget('cart');
        return redirect()->route('product.index')->with('success', 'Successfully purchased products!');
    }
}
