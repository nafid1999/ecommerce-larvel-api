<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //

    public function categories()
    {
        return response()->json([
            'status' => 200,
            "data" => Category::all()
        ], 200);
    }

    public function productsByCategory($slug)
    {
        $category = Category::where("slug", $slug)->first();

        if ($category) {
            
            $products = Product::where("category_id", $category->id)->get();
            if (isset($products[0])) {
                return response()->json([
                    'status' => 200,
                    "data" => $products
                ], 200);
            }
        }
        return response()->json([
            'status' => 403,
            "message " => "no products found"
        ]);
    }

    public function getProduct($category_slug,$product_slug){

        $category = Category::where("slug", $category_slug)->first();

        if($category){
          $product=Product::where("category_id",$category->id)
                            ->where("slug",$product_slug)
                            ->where("status",1)
                            ->get();

           if($product){

                return response()->json([
                    'status' => 200,
                    "data" => $product
                ], 200);
           }else{

                return response()->json([
                    'status' => 403,
                    "message" => "No product Found !"
                ]);
           }
          
        }else{
            return response()->json([
                'status' => 403,
                "message" => "No category Found"
            ]);
       }

        }

    }

