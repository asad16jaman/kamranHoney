<?php

namespace App\Helpers;
use App\Models\Category;

class CategoryHelper
{
    public static function category()
    {
        return Category::get();
    }
    
}