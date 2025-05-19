<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
   public function index()
   {
       return view('cart');
   }
   public function checkout()
   {
       return view('checkout');
   }
   public function order_confirmation()
   {
       return view('confirmation');
   }

   //aadd to cart 
   public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "image" => $product->image,
            "price" => $product->price,
            "quantity" => 1
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Product added to cart!');
}

// Add these methods to your CartController
public function update(Request $request)
{
    if($request->id && $request->quantity){
        $cart = session()->get('cart');
        $cart[$request->id]["quantity"] = $request->quantity;
        session()->put('cart', $cart);
        
        return response()->json(['success' => true]);
    }
}

public function remove(Request $request)
{
    if($request->id) {
        $cart = session()->get('cart');
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        
        return response()->json(['success' => true]);
    }
}


}
