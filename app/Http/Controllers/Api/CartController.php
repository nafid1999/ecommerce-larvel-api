<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //

    public function addToCart(Request $request)
    {
        if (auth("sanctum")->check()) {

            $product_id = $request->product_id;
            $qte = $request->qte;
            $user_id = auth("sanctum")->user()->id;

            $product = Product::find($product_id);
            if ($product) {
                $cart='';
                if (Cart::where("product_id", $product_id)->where("user_id", $user_id)->exists()) {
                   $cart= Cart::where("product_id",$product_id)->first();
                    $cart->update([
                        "qte" => $cart->qte+$qte,
                    ]);
                   
                }else{
                    Cart::create([
                        "user_id"=>$user_id,
                        "product_id"=>$product_id,
                        "qte"=>$qte
                    ]);

                }

                return response()->json(
                    [
                        "status" => 200,
                        "message" => "The product added successfully to the cart",
                        "data"=>$cart->qte
                    ]
                );
            } else {
                return response()->json(
                    [
                        "status" => 404,
                        "message" => "product not found",
                    ]
                );
            }
        } else {

            return response()->json(
                [
                    "status" => 401,
                    "message" => "you have to login first",
                ]
            );
        }
    }

    public function viewCart()
    {
        if (auth("sanctum")->check()) {
               
            $cart_items=Cart::where("user_id",1)->get();
            return response()->json(
                [
                    "status" => 200,
                    "cart" => $cart_items
                ]
            );
        }else{

            return response()->json(
                [
                    "status" => 401,
                    "message" => "you have to login first",
                ]
            );

        }
    }


    public function updateCart(Request $request,$id_cart,$scope)
    {   
        if(auth("sanctum")->check()){

       
         $cart=Cart::find($id_cart);

         if($cart){
             if($scope=="inc")
                $cart->update([
                    "qte"=>$cart->qte+1
                ]);
            else{
                $cart->update([
                    "qte"=>$cart->qte-1
                ]);
            }

            return response()->json(
                [
                    "status" => 200,
                    "request"=>$request->qte  
                ]
            ,200);
         }else
         return response()->json(
            [
                "status" => 401,
            ]
        ,401);
     }else{
        return response()->json(
            [
                "status" => 401,
                "message"=>"you are not connected"
            ]
        ,403);
     }
    }

    public function deleteItem($id_cart)
    {
        if(auth("sanctum")->check()){
            $cart=Cart::find($id_cart);

            if($cart){
                if($cart->delete()){
                    return response()->json(
                        [
                            "status" => 200,
                            "message"=>"item deleted successfully"
                        ]
                    ,200);
                 }else{
                    return response()->json(
                        [
                            "status" => 401,
                            "message"=>"Item not deleted try again"
                        ]
                    );

                 }
            }else{
                return response()->json(
                    [
                        "status" => 402,
                        "message"=>$id_cart
                    ]
                );
            }
        }

        }
}


