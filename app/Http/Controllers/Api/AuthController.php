<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
          
     

        $validator=Validator::make($request->all(),[
            "name"=>"required",
            "email"=>"required|email|unique:users,email",
            "password"=>"required",
        ]);

        if($validator->fails()){
           return response()->json(
               [ "status"=>402,
                  "message"=>$validator->messages()
               ]
               );
        }

        $user=User::Create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password)
        ]);

        $token=$user->createToken($user->name.'_token',[''])->plainTextToken;

        return response()->json([
            "status"=>200,
            "user"=>$user,
            "token"=>$token,
            "message"=>"registred successfully"
        ]);

    } 

    public function login(Request $request){
       
        $validator=Validator::make($request->all(),[
            "email"=>"required|email|",
            "password"=>"required",
        ]);

        if($validator->fails()){
           return response()->json(
               [ "status"=>402,
                  "message"=>$validator->messages()
               ]
               );
        }

        $user=User::where("email",$request->email)->first();

          if(!$user || !Hash::check($request->password,$user->password)){

              //$cookie=cookie("cookie",$token,5);
              return response()->json([
                "status"=>401,
                "message"=>"bad credentials"
            ]);
          }
           else{
               $role='';
               if($user->isAdmin==1){
                   $role="admin";
                 $token=$user->createToken($user->name.'_Admintoken',['server:admin'])->plainTextToken;

               }else
                 $token=$user->createToken($user->name.'_token',[''])->plainTextToken;

           return response()->json([
               "status"=>200,
               "message"=>"loged in successfully ", 
               "user"=>$user,
               "token"=>$token,
               "role"=>$role
            ]);
        }
       
       }
    

    public function users(Request $request){
       
         return response()->json(["data"=>User::all()]);
        
     }


    public function logout(Request $request) {
        
        auth()->user()->tokens()->delete();
        
        return response()->json(["status" => 200,"message"=>'Logged out successfully',]);

    }
}
