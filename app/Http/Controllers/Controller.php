<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // upload image
    function imageUpload($request, $image, $directory, $code)
    {
        $doUpload = function ($image) use ($directory, $code) {
            $extention = $image->getClientOriginalExtension();
            $imageName = $code . '_' . uniqId() . '.' . $extention;
            $image->move($directory, $imageName);
            return $directory . '/' . $imageName;
        };
        if (!empty($image) && $request->hasFile($image)) {
            $file = $request->file($image);
            if (is_array($file) && count($file)) {
                $imagesPath = [];
                foreach ($file as $key => $image) {
                    $imagesPath[] = $doUpload($image);
                }
                return $imagesPath;
            } else {
                return $doUpload($file);
            }
        }

        return false;
    }
}