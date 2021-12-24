<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //create method -> post ->in middleware
    public function createCategory(Request $request)
    {
         $request -> validate([

            "name" => "required|unique:categories",

        ]);

        $category = new Category();
        
        $category->name = $request->name;

        $category->save();

        return response()->json([

            "status"=> 1,
            "msg"=>"category created successfully !"

        ]);

    }

    //update method -> post ->in middleware
    public function updateCategory(Request $request , $category_id)
    {
        if(Category::where([
            "id" => $category_id
        ]) -> exists()){

            $category = Category::find($category_id);

            $category->name = isset($request->name) ? $request->name : $category->name ;

            $category->save();

            return response()->json([

                "status"=>1,
                "msg"=>" category updated !! ",

            ]);
        }else{

            return response()->json([

                "status"=>false ,
                "msg"=>"category doesn't exist "

            ]);
        }
    }

    //delete method -> get ->in middleware
    public function deleteCategory($category_id)
    {
        if(Category::where([
            "id" => $category_id
        ]) -> exists()){

            $category = Category::find($category_id);

            $category->delete();

            return response()->json([

                "status"=>1,
                "msg"=>" category deleted !! ",

            ]);
        }else{

            return response()->json([

                "status"=>false ,
                "msg"=>"category doesn't exist "

            ]);
        }
    }
}
