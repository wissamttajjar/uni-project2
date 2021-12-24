<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;
use Laravel\Passport\HasApiTokens;


class Owner extends Model implements AuthenticateContract
{
    use HasFactory , HasApiTokens , Authenticatable;

    public $timestamps = false ;

    protected $fillable =["name" , "email" , "password" , "phone_num"];

    public function products()
    {
    	return $this->hasMany(Product::class);
    }

}
