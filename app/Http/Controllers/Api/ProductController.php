<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Owner;
use Illuminate\Http\Request;
use Carbon\carbon;

class ProductController extends Controller
{
    //create method -> post ->in middleware
    public function createProduct(Request $request)
    {
        //validation
        $request -> validate([

            "category_id" => "required|exists:App\Models\Category,id",
            "name" => "required",
            "main_price" => "required",
            "price1" => "required|lt:main_price",
            "date1" => "required|date|after:now()",
            "price2" => "required|lt:price1",
            "date2" => "required|date|after:date1",
            "price3" => "required|lt:price2",
            "date3" => "required|date|after:date2",
            "quantity" => "required"

        ]);

        //adding new product
        $product = new Product();

        $product->owner_id = auth()->user()->id;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->main_price = $request->main_price;
        $product->price1 = $request->price1;
        $product->date1 = $request->date1;
        $product->price2 = $request->price2;
        $product->date2 = $request->date2;
        $product->price3 = $request->price3;
        $product->date3 = $request->date3;
        $product->quantity = $request->quantity;

        $product->save();

        //response
        return response()->json([

            "status"=> 1,
            "msg"=>"product created successfully !"

        ]);
    }

    //update method -> post ->in middleware
    public function updateProduct(Request $request , $product_id)
    {
        //get owner id
        $owner_id = auth()->user()->id;

        //check if product exists
        if(Product::where([
            "owner_id" => $owner_id ,
            "id" => $product_id
        ]) -> exists()){

            //get product with matching id
            $product = Product::find($product_id);

        //     $request -> validate([

        //     "name" => "required_if:name,null",
        //     "main_price" => "required_if:main_price,null",
        //     "price1" => "required_if:price1,null|lt:main_price",
        //     "date1" => "required_if:date1,null|date",
        //     "price2" => "required_if:price2,null|lt:price1",
        //     "date2" => "required_if:date2,null|date|after:date1",
        //     "price3" => "required_if:price3,null|lt:price2",
        //     "date3" => "required_if:date3,null|date|after:date2",
        //     "quantity" => "required_if:quantity,null"

        // ]);

            //update product data
            $product->name = isset($request->name) ? $request->name : $product->name;
            $product->main_price = isset($request->main_price) ? $request->main_price : $product->main_price;
            $product->price1 = isset($request->price1) ? $request->price1 : $product->price1;
            $product->price2 = isset($request->price2) ? $request->price2 : $product->price2;
            $product->price3 = isset($request->price3) ? $request->price3 : $product->price3;
            $product->quantity = isset($request->quantity) ? $request->quantity : $product->quantity;


            $product->save();

            return response()->json([

                "status"=>1,
                "msg"=>" product updated !! ",

            ]);
        }else{

            return response()->json([

                "status"=>false ,
                "msg"=>"owner product doesn't exist "

            ]);
        }

    }

    //listAll method -> get ->no middleware
    public function listAllProducts()
    {

        //get all products
        $products = Product::get();

        //response
        return response()->json([

            "status"=>1,
            "msg"=>"All products ",
            "data"=>$products

        ]);

    }

    //listSingleProduct method -> get ->no middleware
    public function listSingleProduct($name)
    {
        //get owner id
        $owner_id = auth()->user()->id;

        //check if product exists
        if(Product::where([
            "owner_id" => $owner_id ,
            "name" => $name
        ]) -> exists()){


            $found_product = Product::where([
            "owner_id" => $owner_id ,
            "name" => $name
        ])->first();

            //response if it exists
            return response()->json([

                "status"=>1,
                "msg"=>" product found !! ",
                "data"=>$found_product

            ]);
        }else{

            //response if it doesn't exist
            return response()->json([

                "status"=>false ,
                "msg"=>"owner product doesn't exist "

            ]);
        }
    }

    //listOwnerProducts method -> get ->in middleware
    public function listOwnerProducts()
    {
        //get id's of all the owners
        $owner_id = auth()->user()->id;

        //find id's that match the products
        $products = Owner::find($owner_id)->products;

        //response
        return response()->json([

            "status"=>1,
            "msg"=>"Owner products ",
            "data"=>$products

        ]);
    }

    //delete method -> get ->in middleware
    public function deleteProduct($product_id)
    {
        $owner_id = auth()->user()->id;

        if(Product::where([
            "owner_id" => $owner_id ,
            "id" => $product_id
        ]) -> exists()){

            $product = Product::find($product_id);

            $product->delete();

            return response()->json([

                "status"=>1,
                "msg"=>" product deleted !! ",

            ]);
        }else{

            //response if it doesn't exist
            return response()->json([

                "status"=>false ,
                "msg"=>"owner product doesn't exist "

            ]);
        }
    }
    // public function findProduct($name)
    // {

    //     //check if product exists
    //     if(Product::where([
    //         "name" => $name
    //     ]) -> exists()){


    //         $found_product = Product::where([
    //         "name" => $name
    //     ])->get();

    //         //response if it exists
    //         return response()->json([

    //             "status"=>1,
    //             "msg"=>" product found !! ",
    //             "data"=>$found_product

    //         ]);
    //     }else{

    //         //response if it doesn't exist
    //         return response()->json([

    //             "status"=>false ,
    //             "msg"=>"product doesn't exist ."

    //         ]);
    //     }
    // }

    public function searchProduct(Request $request , $name)
    {
        if(Product::where('name', 'like', "%{$name}%")
                 ->exists()){
            $product = Product::where('name', 'like', "%{$name}%")->get();

        //return $this -> setPrice($name);

        return response()->json([
            "status" => "success",
            "data" => $product
        ]);

        }else{

        return response()->json([
            "status" => false ,
            "msg" => "product doesn't exist ."
        ]);

        }

        
    }

    // public function setPrice($name){
    //     $product = Product::where('name', 'like', "%{$name}%")->first();
    //     $sample=Carbon::create("2021-10-2");        
    //     $d1=Carbon::parse($product->date1);
    //     $d2=Carbon::parse($product->date2);
    //     $d3=Carbon::parse($product->date3); //Carbon::parse($d);
    //     if($sample->greaterThan($d1))


    // }
}
