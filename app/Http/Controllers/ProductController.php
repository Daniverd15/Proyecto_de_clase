<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(){
        $ProductList=Product::limit(10)->orderby('id','desc')->get();
        
        return view('product.index',[
            'misproductos'=>$ProductList
        ]);
    }

    public function create(){
        $categoryList=Category::all();
        return view('product.create',[
            'category'=>$categoryList
        ]);
    }

    public function show($producto){
        return view('product.show');
    }

    public function store(Request $request){
      

    $request->validate([
'nombre'=>'required|min:3|max:250',
'precio'=>'required|numeric',
'description'=>'required',
'imagen'=>'required|image',
'categoria'=>'required|exists:categories,id',
    ]);

    $newProduct=new Product();
    $newProduct->name=$request->get('nombre');
    $newProduct->description=$request->get('descripcion');
    $newProduct->price=$request->get('precio');
    $newProduct->category_id=$request->get('category');
    

    if($request->hasFile('imagen')){
        $ruta=$request->file('imagen')->store('images','public');
        $newProduct->image=$ruta;
    }
    $newProduct->save();
    

        return redirect()->route('product.index');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('product.index');
    }
}

