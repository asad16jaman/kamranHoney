<?php

use App\Models\UserAccess;
use Illuminate\Support\Facades\Auth;

function checkAccess($accessName)
{
    $user = Auth::user();

    if (!$user)
        return false;

    if ($user->type === 'admin') {
        return true;
    }

    $userAccess = UserAccess::where('user_id', $user->id)->first();

    if (!empty($userAccess) && $userAccess->access != null) {
        $access = json_decode($userAccess->access, true) ?? [];
        return in_array($accessName, $access);
    }

    return false;
}


function availableAccesses()
{
    return [
        'Category & Subcategory Access' => [
            'categories.create' => 'Create Category',
            'categories.index' => 'Category List',
            'subcategories.create' => 'Create Subcategory',
            'subcategories.index' => 'Subcategory List',
        ],

        'Brand & Size Access' => [
            'client.create' => 'Create Brand',
            'client.index' => 'Brand List',
            'sizes_colors.index' => 'Create Size & Color',
        ],

        'Coupon Access' => [
            'coupons.create' => 'Create Coupon',
            'coupons.index' => 'Coupon List',
        ],

        'Slider, Banner & Feature Access' => [
            'sliders.create' => 'Create Slider',
            'sliders.index' => 'Slider Lists',
            'features.create' => 'Create Features',
            'features.index' => 'Features List',
            'banners.create' => 'Create Banner',
            'banners.index' => 'Banner Lists',
        ],

        'Product & FAQ Access' => [
            'products.create' => 'Create Product',
            'products.index' => 'Product Lists',
            'products.variants.index' => 'Manage Product Variant',
            'faqs.create' => 'Create FAQ',
            'faqs.index' => 'FAQ Lists',
        ],

        'Review & Policy Access' => [
            'review.index' => 'Reviews',
            'return.index' => 'Return Policy',
            'privacy.index' => 'Privacy Policy',
            'terms.index' => 'Terms & Conditions',
            'contact-us.index' => 'Contact Messages',
        ],

        'Order Access' => [
            'orders.index' => 'All Orders',
            'orders.approved' => 'Approved Orders',
            'orders.pending' => 'Pending Orders',
            'orders.declined' => 'Declined Orders',
            'orders.completed' => 'Completed Orders',
        ],

        'User Access' => [
            'users.create' => 'Create User',
            'users.index' => 'User List',
        ],

        'Settings Access' => [
            'setting' => 'Company Settings',
        ],
    ];
}
