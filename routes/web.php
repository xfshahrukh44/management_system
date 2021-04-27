<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ADMIN PANEL ROUTES---------------------------------------
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    // DASHBOARD
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // BLADE INDEXES----------------------------------------------------------------
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    // ----------------------------------------------------------------------------

    // API RESOURCES-------------------------------------------------
    Route::apiResources(['user'=>'Admin\UserController']);
    Route::apiResources(['post'=>'Admin\PostController']);
    Route::apiResources(['comment'=>'Admin\CommentController']);
    Route::apiResources(['category'=>'Admin\CategoryController']);
    Route::apiResources(['brand'=>'Admin\BrandController']);
    Route::apiResources(['unit'=>'Admin\UnitController']);
    Route::apiResources(['product'=>'Admin\ProductController']);
    Route::apiResources(['product_image'=>'Admin\ProductImageController']);
    // --------------------------------------------------------------

    // SEARCH ROUTES--------------------------------------------------------------------------------------------
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
    Route::get('/search_posts', 'Admin\PostController@search_posts')->name('search_posts');
    Route::get('/search_categories', 'Admin\CategoryController@search_categories')->name('search_categories');
    Route::get('/search_brands', 'Admin\BrandController@search_brands')->name('search_brands');
    Route::get('/search_units', 'Admin\UnitController@search_units')->name('search_units');
    Route::get('/search_products', 'Admin\ProductController@search_products')->name('search_products');
    // ---------------------------------------------------------------------------------------------------------
    
    
    // HELPERS---------------------------------------------------------------------------------------------------------------
    Route::get('/approve_comment', 'Admin\CommentController@approve_comment')->name('approve_comment');
    // ----------------------------------------------------------------------------------------------------------------------
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
