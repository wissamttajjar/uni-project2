<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    //Register method -> post ->no middleware
    public function register(Request $request)
    {
        // validate the data is there ??
        $request->validate([

            "name" => "required",
            "email" => "required|email|unique:owners",
            "password" => "required|confirmed",
            "phone_num" => "required"
        ]);

        //send data to the database
        $owner = new Owner();
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->phone_num = $request->phone_num;
        $owner->password = bcrypt($request->password);

        //save data
        $owner->save();

        //return response
        return response()->json([
            "status"=>1,
            "msg"=>"Owner created !!!"
        ]);

    }

    //login method -> post ->no middleware
    public function login(Request $request)
    {
        // validate the data is there ??
        $login_data = $request->validate([

            "email" => "required",
            "password" => "required"

        ]);

        //check owner
        if(!auth()->attempt($login_data)){

            return response()->json([

                "status"=> false ,
                "msg" => "invalid email or password ."

            ]);
        }

        //create token
        $token =auth()->user()->createToken("auth_token")->accessToken;

        //return response
        return response()->json([
            "status"=>true ,
            "msg"=>"logged in !!" ,
            "access_token"=>$token

        ]);
    }

    //showProfile method -> get ->in middleware
    public function showProfile()
    {
        //get user date
        $user_data = auth()->user();

        //return response
        return response()->json([
            "status"=>true ,
            "msg"=>"User data" ,
            "data"=> $user_data
        ]);
    }

    //logOut method -> post ->in middleware
    public function logOut(Request $request)
    {
        //get user token
        $token = $request->user()->token();

        //revoke token
        $token->revoke();

        //return response
        return response()->json([
            "status"=>true,
            "msg"=>"logged out !"
        ]);
    }
}
