<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'slider_image',
        'slider_title_one',
        'slider_title_two',
        'description',
        'button_text',
        'ip_address',
        'status',
    ];
}