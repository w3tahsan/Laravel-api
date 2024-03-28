<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PassResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;

Route::get('/', [FrontendController::class, 'welcome'])->name('index');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dash');
Route::get('/product/details/{slug}', [FrontendController::class, 'product_details'])->name('product.details');
Route::post('/getSize', [FrontendController::class, 'getSize']);
Route::post('/getQuantity', [FrontendController::class, 'getQuantity']);
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/recent/view', [FrontendController::class, 'recent_view'])->name('recent.view');
Route::get('/tag/product/{id}', [FrontendController::class, 'tag_product'])->name('tag.product');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//banner
Route::get('/banner', [BannerController::class, 'banner'])->name('banner');
Route::post('/banner/store', [BannerController::class, 'banner_store'])->name('banner.store');

//User
Route::get('/user/update', [UserController::class, 'user_update'])->name('user.update');
Route::post('/user/info/update', [UserController::class, 'user_info_update'])->name('user.info.update');
Route::post('/password/update', [UserController::class, 'password_update'])->name('password.update');
Route::post('/photo/update', [UserController::class, 'photo_update'])->name('photo.update');

//User
Route::post('/user/add', [HomeController::class, 'user_add'])->name('user.add');
Route::get('/user/list', [HomeController::class, 'user_list'])->name('user.list');
Route::get('/user/delete/{user_id}', [HomeController::class, 'user_delete'])->name('user.delete');

//Category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/soft/delete/{category_id}', [CategoryController::class, 'category_soft_delete'])->name('category.soft.delete');
Route::get('/category/trash', [CategoryController::class, 'category_trash'])->name('category.trash');
Route::get('/category/restore/{id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/permanent/delete/{id}', [CategoryController::class, 'category_permanent_delete'])->name('category.permanent.delete');
Route::get('/category/edit/{id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/update/{id}', [CategoryController::class, 'category_update'])->name('category.update');
Route::post('/checked/delete', [CategoryController::class, 'checked_delete'])->name('checked.delete');
Route::post('/checked/restore', [CategoryController::class, 'checked_restore'])->name('checked.restore');

//Subcategory
Route::get('/subcategory', [SubcategoryController::class, 'subcategory'])->name('sub.category');
Route::post('/subcategory/store', [SubcategoryController::class, 'subcategory_store'])->name('sub.category.store');
Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'subcategory_edit'])->name('sub.category.edit');
Route::post('/subcategory/update/{id}', [SubcategoryController::class, 'subcategory_update'])->name('sub.category.update');
Route::get('/subcategory/delete/{id}', [SubcategoryController::class, 'subcategory_delete'])->name('sub.category.delete');

//Product
Route::get('/add/product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');
Route::post('/getstatus', [ProductController::class, 'getstatus']);

//Brand
Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/brand/store', [BrandController::class, 'brand_store'])->name('brand.store');

//Variation
Route::get('/variation', [VariationController::class, 'variation'])->name('variation');
Route::post('/color/store', [VariationController::class, 'color_store'])->name('color.store');
Route::post('/size/store', [VariationController::class, 'size_store'])->name('size.store');

//Inventory
Route::get('/inventory/{id}', [InventoryController::class, 'add_inventory'])->name('add.inventory');
Route::post('/inventory/store/{id}', [InventoryController::class, 'inventory_store'])->name('inventory.store');

//Tag
Route::get('/tag', [TagController::class, 'tag'])->name('tag');
Route::post('/tag/store', [TagController::class, 'tag_store'])->name('tag.store');

//offer
Route::get('/offer', [OfferController::class, 'offer'])->name('offer');
Route::post('/offer/update/{id}', [OfferController::class, 'offer1_update'])->name('offer1.update');
Route::post('/offer2/update/{id}', [OfferController::class, 'offer2_update'])->name('offer2.update');

//subscribe
Route::get('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
Route::post('/subscribe/store', [FrontendController::class, 'subscribe_store'])->name('subscribe.store');

//Customer
Route::get('/customer/githubredirect', [CustomerAuthController::class, 'githubredirect_login'])->name('githubredirect.login');
Route::get('/customer/githubcallback', [CustomerAuthController::class, 'githubcallback_login'])->name('githubcallback.login');
Route::get('/customer/googleredirect', [CustomerAuthController::class, 'googleredirect_login'])->name('googleredirect.login');
Route::get('/customer/googlecallback', [CustomerAuthController::class, 'googlecallback_login'])->name('googlecallback.login');
Route::get('/customer/login', [CustomerAuthController::class, 'customer_login'])->name('customer.login');
Route::get('/customer/register', [CustomerAuthController::class, 'customer_register'])->name('customer.register');
Route::post('/customer/store', [CustomerAuthController::class, 'customer_store'])->name('customer.store');
Route::post('/customer/logged', [CustomerAuthController::class, 'customer_logged'])->name('customer.logged');
Route::get('/customer/profile', [CustomerController::class, 'customer_profile'])->name('customer.profile');
Route::get('/customer/logout', [CustomerController::class, 'customer_logout'])->name('customer.logout');
Route::post('/customer/profile/update', [CustomerController::class, 'profile_update'])->name('profile.update');
Route::get('/customer/my/orders', [CustomerController::class, 'my_orders'])->name('my.orders');
Route::get('/downlaod/invoice/{id}', [CustomerController::class, 'download_invoice'])->name('download.invoice');
Route::get('/customer/email/verify/{token}', [CustomerController::class, 'customer_email_verify'])->name('customer.email.verify');
Route::get('/resend/email/verify', [CustomerController::class, 'resend_email_verify'])->name('resend.email.verify');
Route::post('/resend/link/send', [CustomerController::class, 'resend_link_send'])->name('resend.link.send');

Route::get('/reload-captcha', [CustomerAuthController::class, 'reloadCaptcha']);

//Cart
Route::post('/add/cart', [CartController::class, 'add_cart'])->name('add.cart');
Route::get('/cart/remove/{id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'cart'])->middleware('customer')->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');

//Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');
Route::get('/coupon/status/{id}', [CouponController::class, 'coupon_status'])->name('coupon.status');

//checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order.store');
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');

//Orders
Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status/update/{id}', [OrderController::class, 'order_status_update'])->name('order.status.update');
Route::get('/cancel/order/{id}', [OrderController::class, 'cancel_order'])->name('cancel.order');
Route::post('/order/cancel/req/{id}', [OrderController::class, 'cancel_order_req'])->name('cancel.order.req');
Route::get('/order/cancel/list', [OrderController::class, 'cancel_order_list'])->name('cancel.order.list');
Route::get('/order/cancel/details/{id}', [OrderController::class, 'cancel_details'])->name('cancel.details');
Route::get('/order/cancel/accept/{id}', [OrderController::class, 'cancel_accept'])->name('cancel.accept');

// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('sslpay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


//Stripe
Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


//Review
Route::post('/review/store/{id}', [FrontendController::class, 'review_store'])->name('review.store');


//Role Manager
Route::get('/role/manager', [RoleController::class, 'role_manage'])->name('role.manage');
Route::post('/permission/store', [RoleController::class, 'permission_store'])->name('permission.store');
Route::post('/role/store', [RoleController::class, 'role_store'])->name('role.store');
Route::get('/delete/role/{id}', [RoleController::class, 'delete_role'])->name('delete.role');
Route::get('/edit/role/{id}', [RoleController::class, 'edit_role'])->name('edit.role');
Route::post('/update/role/{id}', [RoleController::class, 'update_role'])->name('update.role');
Route::post('/assign/role', [RoleController::class, 'assign_role'])->name('assign.role');
Route::get('/remove/role/{id}', [RoleController::class, 'remove_role'])->name('remove.role');

//Forget Password
Route::get('/forget/password', [PassResetController::class, 'forget_password'])->name('forget.password');
Route::post('/password/reset/req', [PassResetController::class, 'pass_reset_req'])->name('pass.reset.req');
Route::get('/password/reset/form/{token}', [PassResetController::class, 'password_reset_form'])->name('password.reset.form');
Route::post('/password/reset/confirm/{token}', [PassResetController::class, 'password_reset_confirm'])->name('password.reset.confirm');


//api categories
Route::get('api/category', [FrontendController::class, 'api_category']);

// Log
Route::get('/log/info', [LogController::class, 'log_info'])->name('log.info');
