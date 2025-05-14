<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

  public function categories()
{
    $categories = Category::withCount('products')->orderBy('id', 'desc')->paginate(10);
    return view('admin.categories', compact('categories'));
}


    //add category
    public function add_category(){
        return view('admin.category_add');
    }


    public function store_category(Request $request){
        $request->validate([
            'name' =>'required|string|max:255',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]) ;

        $category = new Category();
        $category->name = $request->name ;
        $image = $request->file('image');
        $file_extension = $request->file('image')->getExtension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->genereate_category_thumbails_image($image , $file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('success', 'Category added successfully');
    }

    public function genereate_category_thumbails_image($image , $image_name){
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124 , 124 ,"top");
        $img->resize(124 , 124 , function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $image_name);
    } 




    // edit category
    public function edit_category($id){
        $category = Category::find($id);
        if ($category) {
            return view('admin.category_edit', compact('category'));
        } else {
            return redirect()->route('admin.categories')->with('error', 'Category not found');
        }
    }
 public function update_category(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $category = Category::find($id);
    if ($category) {
        $category->name = $request->name;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->getClientOriginalExtension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;

            // Move the file to the uploads directory
            $image->move(public_path('uploads/categories'), $file_name);

            // Save the file name in the DB
            $category->image = $file_name;
        }

        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully');
    } else {
        return redirect()->route('admin.categories')->with('error', 'Category not found');
    }
}

    
//delete
    public function delete_category($id){
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return redirect()->route('admin.categories')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->route('admin.categories')->with('error', 'Category not found');
        }
    }



    //produits 
    public function products(){
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products', compact('products'));
    }

    // add product 
    public function add_product(){
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        
        return view('admin.product_add' , compact('categories'));
    }

    // store product
    public function store_product(Request $request ){

        $request->validate([
            'name' =>'required|string|max:255',
            'description'=>'required|string|max:255',
            'price'=>'required|numeric',
            'quantity'=>'required|integer',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id'=>'required|exists:categories,id'

        ]);
         $product = new Product();
        $product->name = $request->name ;
        $image = $request->file('image');
        $file_extension = $request->file('image')->getExtension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->genereate_product_thumbails_image($image , $file_name);
        $product->image = $file_name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->save();
        return redirect()->route('admin.products')->with('success', 'product added successfully');
        
    }

    public function genereate_product_thumbails_image($image , $image_name){
        $destinationPath = public_path('uploads/products');
        $img = Image::read($image->path());
        $img->cover(124 , 124 ,"top");
        $img->resize(124 , 124 , function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $image_name);
    } 

    // edit product
     public function edit_product($id){
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        if ($product) {
            return view('admin.product_edit', compact('product' , 'categories'));
        } else {
            return redirect()->route('admin.products')->with('error', 'Category not found');
        }
    }
 public function update_product(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'quantity'=>'required|integer',
        'price'=>'required|numeric',
        'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id'=>'required|exists:categories,id'
    ]);

    $product = Product::find($id);
    if ($product) {
         $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->category_id = $request->category_id;


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->getClientOriginalExtension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;

            // Move the file to the uploads directory
            $image->move(public_path('uploads/products'), $file_name);

            // Save the file name in the DB
            $product->image = $file_name;
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Category updated successfully');
    } else {
        return redirect()->route('admin.products')->with('error', 'Category not found');
    }
}


 //deelete 
    public function delete_product($id){
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
        } else {
            return redirect()->route('admin.products')->with('error', 'Product not found');
        }
    }   

    
}
