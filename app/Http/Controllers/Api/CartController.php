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


    public function updateCart(Request $request,$id_cart)
    {
         $cart=Cart::find($id_cart);

         if($cart){

            $cart->update([
                "qte"=>$request->qte
            ]);

            return response()->json(
                [
                    "status" => 200,
                ]
            ,200);
         }else
         return response()->json(
            [
                "status" => 401,
            ]
        ,401);


    }
}
