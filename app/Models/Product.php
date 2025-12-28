<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'client_id',
        'name',
        'slug',
        'short_description',
        'description',
        'thumbnail_image',
        'gallery_images',
        'sizes',
        'colors',
        'ip_address',
        'status',
        'is_featured',
        'is_top_selling',
        'is_popular',
        'is_special',
        'is_best',
        'is_new',
        'price',
        'discount_price',
        'product_code',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function banners()
    {
        return $this->belongsToMany(Banner::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
