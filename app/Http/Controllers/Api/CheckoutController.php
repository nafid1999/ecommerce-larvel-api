<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    //

    public function placeOrder(Request $request)
    {  

       if(auth("sanctum")->check()){

      

            $validator=Validator::make($request->all(),[
                "first_name"=>"required",
                "last_name"=>"required",
                "phone"=>"required|digits:10",
                "email"=>"email",
                "zip_code"=>"required|digits:5",
                "adress"=>"required",
                "state"=>"required",
                "city"=>"required",
            ]);

            

            if($validator->fails()){
                return response()->json(
                    [  "status"=>422,
                        "message"=>$validator->messages()
                    ]
                    );
            }else{
                $user_id=auth("sanctum")->user()->id;
                $cart=Cart::where("user_id",$user_id)->get();

               $order= Order::create([
                    "first_name"=>$request->first_name,
                    "user_id"=>$user_id,
                    "last_name"=>$request->last_name,
                    "email"=>$request->email,
                    "phone"=>$request->phone,
                    "adress"=>$request->adress,
                    "city"=>$request->city,
                    "state"=>$request->state,
                    "zip_code"=>$request->zip_code,
                    "payment_mode"=>"COD",
                    "no_tracking"=>"tracking".rand(11111,99999)
                ]);

              

                $cart_items=[];
                foreach($cart as $item){
                    $cart_items[]=[
                        "product_id"=>$item->product_id,
                        "qte"=>$item->qte,
                        "price"=>$item->product->price
                    ];

                    $item->product->update([
                        "qte"=>$item->product->qte-$item->qte
                    ]);
                }

                return response()->json(
                    [
                        "status" => 401,
                        "message" => $cart_items,
                    ]
                );

             $order->orderItems->createMany($cart_items);
             Cart::destroy($cart);

            }

       }else{
            return response()->json(
                [
                    "status" => 401,
                    "message" => "you have to login first",
                ]
            );
       }
    }
}
