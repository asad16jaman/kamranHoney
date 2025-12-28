<?php

namespace App\Helpers;

use App\Models\Client;


class ClientHelper
{
    public static function client()
    {
        return Client::get();
    }
}
