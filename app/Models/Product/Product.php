<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
    	'p_name',
    	'p_qty',
    	'p_desc',
    	'p_img',
    ];
}
