<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Order;
use Illuminate\Http\Request;
use Mail;
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

    public function getCatalog(Request $request, $category, $subcategory = false)
    {
        if($category){
            if($subcategory){
                $products = Product::where([['category', '=', $category],['subcategory', '=', $subcategory]]) -> get();

            } else {
                $products = Product::where('category',$category) -> get();
            }
        }
        return view('shop.index', ['products' => $products]);
    }

    public function getColorInstruments()
    {
        $products = Product::where('category',2) -> get();
        return view('shop.index', ['products' => $products]);
    }

    public function getView(Request $request, $id)
    {
        $product = Product::find($id);
        return view('shop.view', ['product' => $product]);
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
            $emptycart = (object)['items'=>[]];
            if(!$request->ajax())
                return view('shop.shopping-cart');
            else
                return response()->json($emptycart);
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
        $order->phone = $request->input('phone');
        $order->amount = $cart->totalPrice;

        Auth::user()->orders()->save($order);

        Mail::send('mail.order', ['order' => $order,'cart' => $cart], function($message) {

            $message->to("autoshop716@gmail.com")
                ->subject('Order to u');
        });
        Session::forget('cart');
        return redirect()->route('product.index')->with('success', 'Successfully purchased products!');
    }
}
