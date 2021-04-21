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
    // Route::apiResources(['area'=>'Admin\AreaController']);
    // Route::apiResources(['market'=>'Admin\MarketController']);
    // Route::apiResources(['category'=>'Admin\CategoryController']);
    // Route::apiResources(['brand'=>'Admin\BrandController']);
    // Route::apiResources(['unit'=>'Admin\UnitController']);
    // Route::apiResources(['product'=>'Admin\ProductController']);
    // Route::apiResources(['special_discount'=>'Admin\SpecialDiscountController']);
    // Route::apiResources(['ledger'=>'Admin\LedgerController']);
    // Route::apiResources(['stock_in'=>'Admin\StockInController']);
    // Route::apiResources(['stock_out'=>'Admin\StockOutController']);
    // Route::apiResources(['order'=>'Admin\OrderController']);
    // Route::apiResources(['invoice'=>'Admin\InvoiceController']);
    // Route::apiResources(['vendor'=>'Admin\VendorController']);
    // Route::apiResources(['receiving'=>'Admin\ReceivingController']);
    // Route::apiResources(['payment'=>'Admin\PaymentController']);
    // Route::apiResources(['expense'=>'Admin\ExpenseController']);
    // Route::apiResources(['marketing'=>'Admin\MarketingController']);
    // Route::apiResources(['customer_image'=>'Admin\CustomerImageController']);
    // Route::apiResources(['product_image'=>'Admin\ProductImageController']);
    // --------------------------------------------------------------

    // SEARCH ROUTES--------------------------------------------------------------------------------------------
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
    Route::get('/search_posts', 'Admin\PostController@search_posts')->name('search_posts');
    // Route::get('/search_customers', 'Admin\CustomerController@search_customers')->name('search_customers');
    // Route::get('/search_products', 'Admin\ProductController@search_products')->name('search_products');
    // Route::get('/search_ledgers', 'Admin\LedgerController@search_ledgers')->name('search_ledgers');
    // Route::get('/search_stockIns', 'Admin\StockInController@search_stockIns')->name('search_stockIns');
    // Route::get('/search_stockOuts', 'Admin\StockOutController@search_stockOuts')->name('search_stockOuts');
    // Route::get('/search_orders', 'Admin\OrderController@search_orders')->name('search_orders');
    // Route::get('/search_invoices', 'Admin\InvoiceController@search_invoices')->name('search_invoices');
    // Route::get('/search_vendors', 'Admin\VendorController@search_vendors')->name('search_vendors');
    // Route::get('/search_receivings', 'Admin\ReceivingController@search_receivings')->name('search_receivings');
    // Route::get('/search_payments', 'Admin\PaymentController@search_payments')->name('search_payments');
    // Route::get('/search_expenses', 'Admin\ExpenseController@search_expenses')->name('search_expenses');
    // Route::get('/search_marketings', 'Admin\MarketingController@search_marketings')->name('search_marketings');
    // Route::get('/search_customer_ledgers', 'Admin\LedgerController@search_customer_ledgers')->name('search_customer_ledgers');
    // Route::get('/search_vendor_ledgers', 'Admin\LedgerController@search_vendor_ledgers')->name('search_vendor_ledgers');
    // ---------------------------------------------------------------------------------------------------------
    
    
    // HELPERS---------------------------------------------------------------------------------------------------------------
    Route::get('/approve_comment', 'Admin\CommentController@approve_comment')->name('approve_comment');
    // ----------------------------------------------------------------------------------------------------------------------
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
