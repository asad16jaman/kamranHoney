<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_phone',
        'hotline',
        'company_slogan',
        'company_email',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
        'inside',
        'outside',

        'favicon_image',
        'company_logo',
        'footer_logo',
        'footer_title',
        'footer_short_description',
        'footer_description',
        'company_about',
        'google_map',
        'office_hour',
        'copyright',
    ];
}
