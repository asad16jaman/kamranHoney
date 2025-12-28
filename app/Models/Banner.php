<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_image',
        'title_one',
        'title_two',
        'description',
        'start_date',
        'end_date',
        'discount',
        'button_text',
        'ip_address',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime:d-m-y h:i:s',
        'end_date' => 'datetime:d-m-y h:i:s',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
