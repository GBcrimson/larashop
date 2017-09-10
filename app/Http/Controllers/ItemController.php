<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Auth;

class ItemController extends Controller
{
    public function getItem($id)
    {
        $product = Product::findOrFail($id);
        return view('items.index', ['product' => $product]);
    }

    public function getNewItem()
    {
        return view('items.index');
    }

    public function postItem(Request $request)
    {
        $item = Product::create([
            'imagePath' => $request->input('imagePath'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'price' => $request->input('price')
        ]);

        if(!$request->ajax())
            return redirect()->route('product.index');
        else
            return response()->json($item);
    }

    public function putItem(Request $request, $id) {
        $item = Product::findOrFail($id);

        $item->imagePath = $request->input('imagePath');
        $item->title = $request->input('title');
        $item->description = $request->input('description');
        $item->category = $request->input('category');
        $item->price = $request->input('price');

        $item->save();

        if(!$request->ajax())
            return redirect()->route('product.index');
        else
            return response()->json($item);
    }

    public function deleteItem(Request $request, $id) {
        $item = Product::findOrFail($id);
        $item->delete();

        if(!$request->ajax())
            return redirect()->route('product.index');
        else
            return response()->json($item);
    }
}
