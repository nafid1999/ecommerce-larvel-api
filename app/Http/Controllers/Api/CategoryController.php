<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
            "data"=>Category::all()
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
           "name"=>"required|max:50|unique:categories,name",   
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>403,
                "message"=>$validator->messages()
            ]);
        }else{

            $slug=$request->input("slug")?$request->input("slug"):Str::slug($request->input("name"));
             Category::create([
                "name"=>$request->name,
                "slug"=>$slug,
                "description"=>$request->description,
                "metaTitle"=>$request->input("metaTitle"),
                "metaDesc"=>$request->input("metaDesc"),
                "metaKeywords"=>$request->input("metaKeywords"),
            ]);

            return response()->json([
                'status'=>200,
                "message"=>"category added successfully "
            ],200);

        }
    }

    public function edit($id){
          $category=Category::find($id);
        if(isset($category)){
            return response()->json([
                'status'=>200,
                "category"=>$category
            ],200);
        }
        return response()->json([
            'status'=>403,
            "message"=>"category not found"
        ],200);

    }

   
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $category=Category::find($id);
        $validator=Validator::make($request->all(),[
            "name"=>"required|max:50",   
         ]);
 
         if($validator->fails()){
             return response()->json([
                 'status'=>403,
                 "message"=>$validator->messages()
             ]);
         }else{
 
             $category->update([
                 "name"=>$request->name,
                 "slug"=>$request->slug,
                 "description"=>$request->description,
                 "metaTitle"=>$request->input("metaTitle"),
                 "metaDesc"=>$request->input("metaDesc"),
                 "metaKeywords"=>$request->input("metaKeywords"),
             ]);
 
             return response()->json([
                 'status'=>200,
                 "category"=>$category,
                 "message"=>"category updated successfully "
             ],200);
 
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       if( Category::find($id)->delete())
        return response()->json([
            'status'=>200,
            "message"=>"category deleted successfully "
        ],200);

        else
            return response()->json([
                'status'=>403,
                "message"=>"there is an error "
            ]);
    }
}
