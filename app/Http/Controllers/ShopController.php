<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
  public function index()
  {
    $products = Product::orderBy('created_at', 'desc')->paginate(10);
    $categories = Category::orderBy('created_at', 'desc')->get();
    return view('shop' ,  compact('products' , 'categories'));
  }

 public function product_detail($id)
{
    $product = Product::find($id);
    $categories = Category::get();

    if (!$product) {
        abort(404, 'Product not found');
    }

    return view('product-detail', compact('product' , 'categories'));
}

}
