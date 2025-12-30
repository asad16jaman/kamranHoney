<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\admin\NewsController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\ClientController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\DealerController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\AboutUsController;
use App\Http\Controllers\admin\CounterController;
use App\Http\Controllers\admin\FeatureController;
use App\Http\Controllers\admin\GalleryController;
use App\Http\Controllers\admin\MessageController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\FavoriteController;
use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\admin\ContactUsController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ManagementController;
use App\Http\Controllers\admin\CertificateController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\CustomerController;
use App\Http\Controllers\admin\ReturnPolicyController;
use App\Http\Controllers\admin\PrivacyPolicyController;
use App\Http\Controllers\frontend\FacilitiesController;
use App\Http\Controllers\admin\AuthenticationController;
use App\Http\Controllers\admin\ProductVariantController;
use App\Http\Controllers\admin\TermsConditionController;
use App\Http\Controllers\frontend\FrontProductController;
use App\Http\Controllers\frontend\CustomerOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('about',[AboutUsController::class, 'view'])->name('about.view');

Route::get('all-products',[FrontProductController::class, 'index'])->name('all.products');

Route::get('contact',[ContactUsController::class, 'create'])->name('contact.create');


// Authentication
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('admin');
    Route::post('/login', [AuthenticationController::class, 'loginCheck'])->name('admin.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    // Update Profile
    Route::get('/profile', [AuthenticationController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [AuthenticationController::class, 'updateProfile'])->name('profile.update');

    // Change Password
    Route::get('/change-password', [AuthenticationController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthenticationController::class, 'updatePassword'])->name('password.update');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::put('/users/update-status/{id}', [UserController::class, 'updateStatus'])->name('users.updateStatus');
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // User Access
    Route::put('/user/{user}/access', [UserController::class, 'updateAccess'])->name('user.access.update');

    // sliders
    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
    Route::get('/sliders/create', [SliderController::class, 'create'])->name('sliders.create');
    Route::post('/sliders/store', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('/sliders/edit/{id}', [SliderController::class, 'edit'])->name('sliders.edit');
    Route::put('/sliders/update/{id}', [SliderController::class, 'update'])->name('sliders.update');
    Route::put('/sliders/update-status/{id}', [SliderController::class, 'updateStatus'])->name('sliders.updateStatus');
    Route::delete('/sliders/destroy/{id}', [SliderController::class, 'destroy'])->name('sliders.destroy');

    // Banners
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners/store', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/edit/{id}', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/update/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::put('/banners/update-status/{id}', [BannerController::class, 'updateStatus'])->name('banners.updateStatus');
    Route::delete('/banners/destroy/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');

    // Coupons
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/edit/{id}', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/update/{id}', [CouponController::class, 'update'])->name('coupons.update');
    Route::put('/coupons/update-status/{id}', [CouponController::class, 'updateStatus'])->name('coupons.updateStatus');
    Route::delete('/coupons/destroy/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');

    // Features
    Route::get('/features', [FeatureController::class, 'index'])->name('features.index');
    Route::get('/features/create', [FeatureController::class, 'create'])->name('features.create');
    Route::post('/features/store', [FeatureController::class, 'store'])->name('features.store');
    Route::get('/features/edit/{id}', [FeatureController::class, 'edit'])->name('features.edit');
    Route::put('/features/update/{id}', [FeatureController::class, 'update'])->name('features.update');
    Route::put('/features/update-status/{id}', [FeatureController::class, 'updateStatus'])->name('features.updateStatus');
    Route::delete('/features/destroy/{id}', [FeatureController::class, 'destroy'])->name('features.destroy');

    // Client
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
    Route::post('/client/store', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client/edit/{id}', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('/client/update/{id}', [ClientController::class, 'update'])->name('client.update');
    Route::put('/client/update-status/{id}', [ClientController::class, 'updateStatus'])->name('client.updateStatus');
    Route::delete('/client/destroy/{id}', [ClientController::class, 'destroy'])->name('client.destroy');

    // Unit
    Route::get('/unit', [UnitController::class, 'index'])->name('unit.index');
    Route::get('/unit/create', [UnitController::class, 'create'])->name('unit.create');
    Route::post('/unit/store', [UnitController::class, 'store'])->name('unit.store');
    Route::get('/unit/edit/{id}', [UnitController::class, 'edit'])->name('unit.edit');
    Route::put('/unit/update/{id}', [UnitController::class, 'update'])->name('unit.update');
    Route::put('/unit/update-status/{id}', [UnitController::class, 'updateStatus'])->name('unit.updateStatus');
    Route::delete('/unit/destroy/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::put('/categories/update-status/{id}', [CategoryController::class, 'updateStatus'])->name('categories.updateStatus');
    Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // SubCategories
    Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/subcategories/create', [SubCategoryController::class, 'create'])->name('subcategories.create');
    Route::post('/subcategories/store', [SubCategoryController::class, 'store'])->name('subcategories.store');
    Route::get('/subcategories/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('/subcategories/update/{id}', [SubCategoryController::class, 'update'])->name('subcategories.update');
    Route::put('/subcategories/update-status/{id}', [SubCategoryController::class, 'updateStatus'])->name('subcategories.updateStatus');
    Route::delete('/subcategories/destroy/{id}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');

    // Size Color Attributes
    Route::get('/sizes-colors', [AttributeController::class, 'index'])->name('sizes_colors.index');
    Route::post('/color/store', [AttributeController::class, 'storeColor'])->name('colors.store');
    Route::put('/color/update/{id}', [AttributeController::class, 'updateColor'])->name('colors.update');
    Route::put('/color/status/{id}', [AttributeController::class, 'updateColorStatus'])->name('colors.updateStatus');
    Route::delete('/color/delete/{id}', [AttributeController::class, 'destroyColor'])->name('colors.destroy');

    Route::post('/size/store', [AttributeController::class, 'storeSize'])->name('sizes.store');
    Route::put('/size/update/{id}', [AttributeController::class, 'updateSize'])->name('sizes.update');
    Route::put('/size/status/{id}', [AttributeController::class, 'updateSizeStatus'])->name('sizes.updateStatus');
    Route::delete('/size/delete/{id}', [AttributeController::class, 'destroySize'])->name('sizes.destroy');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::put('/products/update-status/{id}', [ProductController::class, 'updateStatus'])->name('products.updateStatus');
    Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Product Variants
    Route::get('/product-variants', [ProductVariantController::class, 'index'])->name('products.variants.index');
    Route::post('/products/{product}/variants', [ProductVariantController::class, 'store'])->name('products.variants.store');
    Route::put('/product-variants/{variant}', [ProductVariantController::class, 'update'])->name('products.variants.update');

    // Faq
    Route::get('/faq', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faq/create', [FaqController::class, 'create'])->name('faqs.create');
    Route::post('/faq/store', [FaqController::class, 'store'])->name('faqs.store');
    Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('faqs.edit');
    Route::put('/faq/update/{id}', [FaqController::class, 'update'])->name('faqs.update');
    Route::put('/faq/update-status/{id}', [FaqController::class, 'updateStatus'])->name('faqs.updateStatus');
    Route::delete('/faq/destroy/{id}', [FaqController::class, 'destroy'])->name('faqs.destroy');

    // Blog
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs/store', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/update/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::put('/blogs/update-status/{id}', [BlogController::class, 'updateStatus'])->name('blogs.updateStatus');
    Route::delete('/blogs/destroy/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');


    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::put('/reviews/update-status/{id}', [ReviewController::class, 'updateStatus'])->name('reviews.updateStatus');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Order Items
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/update-status/{id}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('/orders/{id}/tracking', [OrderController::class, 'updateTracking'])->name('orders.updateTracking');
    Route::delete('/orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // About-us
    Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us.index');
    Route::put('/about-us/update', [AboutUsController::class, 'update'])->name('about-us.update');

    // Return Policy
    Route::get('/return', [ReturnPolicyController::class, 'index'])->name('return.index');
    Route::put('/return/update', [ReturnPolicyController::class, 'update'])->name('return.update');

    // Privacy Policy
    Route::get('/privacy', [PrivacyPolicyController::class, 'index'])->name('privacy.index');
    Route::put('/privacy/update', [PrivacyPolicyController::class, 'update'])->name('privacy.update');

    // Terms & Conditions
    Route::get('/terms', [TermsConditionController::class, 'index'])->name('terms.index');
    Route::put('/terms/update', [TermsConditionController::class, 'update'])->name('terms.update');

    // Contact-us
    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us.index');
    Route::delete('/contact-us/{id}', [ContactUsController::class, 'destroy'])->name('contact-us.destroy');

    // settings
    Route::get('/setting', [SettingController::class, 'setting'])->name('setting');
    Route::put('/setting', [SettingController::class, 'update'])->name('setting.update');
});
