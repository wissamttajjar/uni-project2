<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;


class Product extends Model
{
    use HasFactory;

    public $timestamps = false ;

    protected $fillable =["category_id" , "owner_id" ,"name" , "main_price", "current_price" , "price1" , "date1" , "price2" , "date2" , "price3" , "date3" , "quantity" ];

    public function images()
    {
    	return $this->hasMany(Image::class);
    }

}
