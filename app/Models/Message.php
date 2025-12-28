<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'message',
        'image',
        'name_2',
        'designation_2',
        'message_2',
        'image_2',
        'ip_address',
    ];
}
