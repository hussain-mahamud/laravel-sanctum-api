<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        return response()->json([
            'products'=>$products],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try{
        $request->validate([
                'p_name'       => 'required',
                'p_qty'        => 'required',
                'p_img'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000',
                
            ]);
        $file=$request->file('p_img');
        $p_img=$request->file('p_img')->getClientOriginalName();
        $file->move(public_path('product'),$p_img);
        $product=Product::create([
            'p_name'=>$request->p_name,
            'p_qty'=>$request->p_qty,
            'p_desc'=>$request->p_desc,
            'p_img'=>$p_img]);
        return response()->json([
            'product'=>$product,
            'message'=>'Product Added'],201);
       }
       catch(Exception $error){
            return response()->json([
                'error'=>$error,
                ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::find($id);
        return response()->json([
            'product'=>$product],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
       try{
        $request->validate([
                'p_name'       => 'required',
                'p_qty'        => 'required',
                'p_img'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000',
                
            ]);
        $file=$request->file('p_img');
        $p_img=$file->getClientOriginalName();
        $product=Product::find($id);
        unlink(public_path('product/').$product->p_img);
        $file->move(public_path('product'),$p_img);
        
        $product->p_name=$request->p_name;
        $product->p_qty=$request->p_qty;
        $product->p_desc=$request->p_desc;
        $product->p_img=$p_img;
        $product->save();
        return response()->json([
           'product'=>$product,
            'message'=>'Product Updated'],201);
       }
       catch(Exception $error){
            return response()->json([
                'error'=>$error,
                ],400);
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        unlink(public_path('/product/').$product->p_img);
        $product->delete();
        return response()->json([
            'product'=>$product,
            'message'=>'Product Removed'],200);
    }
}
