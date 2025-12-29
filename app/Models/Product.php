<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_code',
        'category_id',
        'sub_category_id',
        'client_id',
        'name',
        'slug',
        'short_description',
        'description',
        'thumbnail_image',
        'gallery_images',
        'ip_address',
        'status',
    ];

    protected $casts = [
        'gallery_images' => 'array',
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

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
}
