<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return response()->json([
            'status'=>200,
            "data"=>Product::all()
        ],200);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            "name"=>"required|max:50|unique:products,name",  
            "image"=>"required|image|mimes:jpeg,jpg,png|max:2048",
            "brand"=>"required|max:20",
            "price"=>"required|max:20",
            "o_price"=>"required|max:20",
            "qte"=>"required|max:4",
            "category_id"=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>403,
                "st"=>$request->status,
                "message"=>$validator->messages()
            ]);
        }else{

            if($request->hasFile("image")){
                $file=$request->file("image");
                $extension=$file->getClientOriginalExtension();
                $image=time() .".".$extension;

                $file->move("uploads/products/",$image);
            }

            $slug=$request->input("slug")?$request->input("slug"):Str::slug($request->input("name"));
             Product::create([
                "name"=>$request->name,
                "slug"=>$slug,
                "description"=>$request->description,
                "metaTitle"=>$request->input("metaTitle"), 
                "metaDesc"=>$request->input("metaDesc"),
                "metaKeywords"=>$request->input("metaKeywords"),
                'brand'=>$request->brand,
                'status'=>$request->status=='true'?1:0,
                'image'=>"uploads/products/".$image,
                'price'=>$request->price,
                'o_price'=>$request->o_price,
                'qte'=>$request->qte,
                'category_id'=>$request->category_id,
               
            ]);

            return response()->json([
                'status'=>200,
                "message"=>"product added successfully"
            ],200);

        }
    }
        
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $product=Product::find($id);
        if(isset($product)){
            return response()->json([
                'status'=>200,
                "product"=>$product
            ],200);
        }
        return response()->json([
            'status'=>403,
            "message"=>"product not found"
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $product=Product::find($id);
        $validator=Validator::make($request->all(),[
            "name"=>"required|max:50",  
            "brand"=>"required|max:20",
            "price"=>"required|max:20",
            "o_price"=>"required|max:20",
            "qte"=>"required|max:4",
            "category_id"=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>403,
                "st"=>$request->status,
                "message"=>$validator->messages()
            ]);
        }else{
            if($request->hasFile("image") and isset($request->image)){

                $path=$product->image;
                if(File::exists($path))
                {
                    File::delete($path);
                }
                $file=$request->file("image");
                $extension=$file->getClientOriginalExtension();
                $image=time() .".".$extension;

                $file->move("uploads/products/",$image);
                $product->image="uploads/products/".$image;
                $product->save();
            }

            $slug=$request->input("slug")?$request->input("slug"):Str::slug($request->input("name"));
             $product->update([
                "name"=>$request->name,
                "slug"=>$slug,
                "description"=>$request->description,
                "metaTitle"=>$request->input("metaTitle"), 
                "metaDesc"=>$request->input("metaDesc"),
                "metaKeywords"=>$request->input("metaKeywords"),
                'brand'=>$request->brand,
                'status'=>$request->status?'1':"0",
                'price'=>$request->price,
                'o_price'=>$request->o_price,
                'qte'=>$request->qte,
                'category_id'=>$request->category_id,
               
            ]);

            return response()->json([
                'status'=>200,
                "message"=>"product added successfully"
            ],200);

    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( Product::find($id)->delete())
        return response()->json([
            'status'=>200,
            "message"=>"product deleted successfully "
        ],200);

        else
            return response()->json([
                'status'=>403,
                "message"=>"there is an error "
            ]);
    }



}
