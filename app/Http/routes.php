<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Http\Controllers\AjaxController;

Route::get('robots.txt', 'PageController@robots')->name('robots');

Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
    Route::post('send-form', [AjaxController::class, 'postSendForm'])->name('send-form');
    Route::post('purge-cart', [AjaxController::class, 'postPurgeCart'])->name('purge-cart');

    Route::post('apply-discount-payment', [AjaxController::class, 'postApplyDiscountPayment'])->name('apply-discount-payment');
    Route::post('discard-discount-payment', [AjaxController::class, 'postDiscardDiscountPayment'])->name('discard-discount-payment');

    Route::post('apply-discount-delivery', [AjaxController::class, 'postApplyDiscountDelivery'])->name('apply-discount-delivery');
    Route::post('discard-discount-delivery', [AjaxController::class, 'postDiscardDiscountDelivery'])->name('discard-discount-delivery');

    Route::post('add-to-cart', [AjaxController::class, 'postAddToCart'])->name('add-to-cart');
    Route::post('update-to-cart', [AjaxController::class, 'postUpdateToCart'])->name('update-to-cart');
    Route::post('remove-from-cart', [AjaxController::class, 'postRemoveFromCart'])->name('remove-from-cart');
    Route::post('purge-cart', [AjaxController::class, 'postPurgeCart'])->name('purge-cart');
    Route::post('edit-cart-product', [AjaxController::class, 'postEditCartProduct'])->name('edit-cart-product');
    Route::post('order', [AjaxController::class, 'postOrder'])->name('order');
	Route::post('request', 'AjaxController@postRequest')->name('request');
	Route::post('subscribe', 'AjaxController@postSubscribe')->name('subscribe');

    Route::post('update-char-value', [AjaxController::class, 'postUpdateProductCharValue'])->name('update-char-value');
    Route::post('add-product-char', [AjaxController::class, 'postAddProductChar'])->name('add-product-char');
    Route::post('delete-product-char', [AjaxController::class, 'postDeleteProductChar'])->name('delete-product-char');
    Route::post('per-page-select', [AjaxController::class, 'postPerPageSelect'])
        ->name('per-page-select');

    Route::get('get-products', 'AjaxController@postGetProducts')->name('get-products');
});

Route::group(['middleware' => ['redirects']], function() {

    Route::get('/', ['as' => 'main', 'uses' => 'WelcomeController@index']);

    Route::any('/delivery-pay', ['as' => 'delivery-pay', 'uses' => 'DeliveryController@index']);

    Route::any('reviews', ['as' => 'reviews', 'uses' => 'ReviewsController@index']);

    Route::any('suppliers', ['as' => 'suppliers', 'uses' => 'SuppliersController@index']);

    Route::any('search', ['as' => 'search', 'uses' => 'CatalogController@search']);
    Route::any('search-brand', ['as' => 'search-brand', 'uses' => 'CatalogController@searchByBrand']);

    Route::any('points', ['as' => 'points', 'uses' => 'PointsController@index']);

    Route::get('cart', ['as' => 'cart', 'uses' => 'CartController@getIndex']);

    Route::get('create-order', ['as' => 'create-order', 'uses' => 'CartController@getCreateOrder']);

    Route::get('order-success/{id?}', ['as' => 'order-success', 'uses' => 'CartController@showSuccess']);

    Route::get('policy', ['as' => 'policy', 'uses' => 'PageController@policy']);

    Route::get('fss', ['as' => 'fss', 'uses' => 'PageController@fss']);

    Route::any('catalog', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);

    Route::any('catalog/{alias}', ['as' => 'catalog.view', 'uses' => 'CatalogController@view'])
        ->where('alias', '([A-Za-z0-9\-\/_]+)');

    Route::any('{alias}', ['as' => 'default', 'uses' => 'PageController@page'])
        ->where('alias', '([A-Za-z0-9\-\/_]+)');
});
