<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $products = Product::get();
        return view('index', compact('products'));
    }
    public function categories(){
        $categories = Category::get();
        return view('categories', compact('categories'));
    }
    public function category($alias){
        $category = Category::where('alias', $alias)->first();
        if(!empty($category)){
            return view('category', compact('category'));
        }else{
            return abort(404);
        }
    }
    public function product($category, $alias = null){
        $product = Product::where('alias', $alias)->first();
        if(!empty($product)){
            return view('product', compact('category','product'));
        }else{
            return abort(404);
        }
    }
}
