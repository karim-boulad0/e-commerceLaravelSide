<?php

use Illuminate\Support\Facades\Route;
//website
use App\Http\Controllers\Auth\AuthController;
//auth
use App\Http\Controllers\socialAuthController;
use App\Http\Controllers\Dashboard\UserController;
//dashboard
use App\Http\Controllers\WebSite\ClientController;
use App\Http\Controllers\WebSite\ContactUsController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Website\ProductReviewController;
use App\Http\Controllers\Dashboard\Product\ProductController;
use App\Http\Controllers\Dashboard\AdminNotificationController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\Order\OrderController as DashboardOrderController;
use App\Http\Controllers\Dashboard\Order\OrderStatisticController;
use App\Http\Controllers\WebSite\Order\OrderItemController;
use App\Http\Controllers\Dashboard\Product\ProductImageController;
use App\Http\Controllers\Dashboard\SettingController;


use App\Http\Controllers\WebSite\ProductController as WebSiteProductController;
use App\Http\Controllers\WebSite\CategoryController as WebSiteCategoryController;
use App\Http\Controllers\WebSite\ClientNotificationController;
use App\Http\Controllers\WebSite\Order\OrderController;
use App\Models\Banner;

/*     ---- Auth [Public Routes] ----       */

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:api');
});
//login with google
Route::get('/login-google', [socialAuthController::class, 'redirectToProvider']);
Route::get('/auth/google/callback', [socialAuthController::class, 'handleCallback']);

/*     ---- Dashboard  [Protected Routes] ----       */

Route::middleware('auth:api')
    ->group(function () {
        Route::get('/user', [UserController::class, 'authUser']);
        Route::prefix('dashboard')->group(function () {
            // Users
            //less than admin
            Route::post('/user/edit/profile/{id}', [UserController::class, 'editProfile']);
            Route::get('/user', [UserController::class, 'authUser']);

            // admin
            Route::middleware('checkAdmin')
                ->controller(UserController::class)->group(function () {
                    Route::get('/users', 'GetUsers');
                    Route::get('/user/{id}', 'getUser');
                    Route::post('/user/edit/{id}', 'editUser');
                    Route::post('/user/add', 'addUser');
                    Route::delete('/user/{id}', 'destroy');
                });

            //order Statistics
            Route::controller(OrderStatisticController::class)->group(function () {
                Route::get('/order/statistic/{day}/{month}/{year}/{status}', 'statistic');
                Route::get('/order/statistic/productsAreAboutRunOut', 'productsAreAboutRunOut');
            });
            // orders
            Route::controller(DashboardOrderController::class)
                ->prefix('orders')->group(function () {
                    Route::get('index', 'index');
                    Route::get('getOrderItemsInfo/{id}', 'getOrderItemsInfo');
                    Route::get('edit/{id}', 'edit');
                    Route::post('update/{id}', 'update');
                    Route::delete('delete/{id}', 'delete');
                });
            // Categories
            Route::middleware('checkProductManager')
                ->controller(CategoryController::class)->group(function () {
                    Route::get('/categories', 'index');
                    Route::post('/category/add', 'store');
                    Route::get('/category/{id}', 'show');
                    Route::post('/category/edit/{id}', 'edit');
                    Route::delete('/category/{id}', 'destroy');
                });
            // banners
            Route::middleware('checkProductManager')->controller(BannerController::class)->group(function () {
                Route::get('/banners', 'index');
                Route::post('/banner/store', 'store');
                Route::get('/banner/{id}', 'show');
                Route::post('/banner/edit/{id}', 'edit');
                Route::delete('/banner/{id}', 'destroy');
            });

            // products
            Route::middleware('checkProductManager')
                ->controller(ProductController::class)->group(function () {
                    Route::get('/products', 'index');
                    Route::post('/product/add', 'store');
                    Route::get('/product/{id}', 'getById');
                    Route::post('/product/edit/{id}', 'update');
                    Route::delete('/product/{id}', 'destroy');
                    Route::get('/filterProducts', 'filterProducts');
                });

            // images of product
            Route::middleware('checkProductManager')
                ->controller(ProductImageController::class)
                ->group(function () {
                    Route::post('/product-img/add', 'store');
                    Route::delete('/product-img/{id}', 'destroy');
                    Route::get('/images/{id}', 'productImages');
                });

            // settings
            Route::post('/settings/update', [SettingController::class, 'update']);
            Route::get('/settings/index', [SettingController::class, 'index']);
            // admin Notifications
            Route::prefix('/admin/notification')->group(function () {
                Route::controller(AdminNotificationController::class)->group(function () {
                    Route::get('/all',  'index');
                    Route::get('/getById/{id}',  'getById');
                    Route::get('/countUnreadNotifications',  'countUnreadNotifications');
                    Route::get('/unreadNotifications',  'unreadNotifications');
                    Route::post('/markAllAsRead',  'markAllAsRead');
                    Route::post('/markAsReadById/{id}',  'markAsReadById');
                    Route::delete('/deleteAll',  'deleteAll');
                    Route::delete('/deleteById/{id}',  'deleteById');
                });
            });
        });
    });


/*     ---- WeBsite  [ public  Routes] ----       */

Route::prefix('webSite')->group(function () {

    // orderItem
    Route::prefix('orderItems')->middleware('auth:api')->group(function () {
        Route::controller(OrderItemController::class)->group(function () {
            Route::get('index', 'index');
            Route::post('addOrderItem/{product_id}', 'addOrderItem');
            Route::post('editOrderItem', 'editOrderItem');
            Route::delete('deleteOrderItem/{id}', 'deleteOrderItem');
        });
    });
    // Orders
    Route::prefix('orders')->middleware('auth:api')->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::get('index', 'index');
            Route::post('confirmAll', 'confirmAll');
        });
    });


    // contact us
    Route::controller(ContactUsController::class)->group(function () {
        Route::post('/contactUs', 'contactUs')->middleware('auth:api');
    });

    //categories
    Route::controller(WebSiteCategoryController::class)->group(function () {
        Route::get('/categories', 'index');
        Route::get('/all', 'all');
        Route::get('/categoriesWithProducts', 'categoriesWithProducts');
        Route::get('/categoriesWithProductsById/{id}', 'categoriesWithProductsById');
    });
    //products
    Route::controller(WebSiteProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/getBestProducts', 'getBestProducts');
        Route::get('/productsWithImages', 'productsWithImages');
        Route::get('/product/{id}', 'product');
    });
    // product reviews
    Route::controller(ProductReviewController::class)->group(function () {
        Route::post('/CreateProductReview/{id}', 'CreateProductReview')->middleware('auth:api');
        Route::post('/editProductRate/{id}', 'editProductRate');
    });

    // user details
    Route::controller(ClientController::class)->group(function () {
        Route::post('/storeDetails', 'storeDetails')->middleware('auth:api');
        Route::get('/showUserDetails', 'show')->middleware('auth:api');
        Route::get('/isAuthExist', 'isAuthExist')->middleware('auth:api');
        Route::get('/checkUserDetails', 'checkUserDetails')->middleware('auth:api');
    });
});
//client notifications
Route::prefix('/client/notification')->middleware('auth:api')
    ->group(function () {
        Route::controller(ClientNotificationController::class)->group(function () {
            Route::get('/all',  'index');
            Route::get('/getById/{id}',  'getById');
            Route::get('/countUnreadNotifications',  'countUnreadNotifications');
            Route::get('/unreadNotifications',  'unreadNotifications');
            Route::post('/markAllAsRead',  'markAllAsRead');
            Route::post('/markAsReadById/{id}',  'markAsReadById');
            Route::delete('/deleteAll',  'deleteAll');
            Route::delete('/deleteById/{id}',  'deleteById');
        });
    });
// settings
Route::get('/settings/index', [SettingController::class, 'index']);
Route::get('/isAuthExist', [ClientController::class, 'isAuthExist'])->middleware('auth:api');
