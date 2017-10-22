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

Route::get('/items', [
    'uses' => 'ProductController@getIndex',
    'as' => 'product.index'
]);

Route::get('/', [
    'uses' => 'ProductController@getIndex',
    'as' => 'product.index'
]);

Route::get('/item/{id}', [
    'uses' => 'ProductController@getView',
    'as' => 'product.view'
]);

Route::get('/catalog/{category}/{subcategory?}', [
    'uses' => 'ProductController@getCatalog',
    'as' => 'product.catalog'
]);

Route::get('/shopping-cart', [
    'uses' => 'ProductController@getCart',
    'as' => 'product.shoppingCart'
]);

Route::get('/checkout', [
    'uses' => 'ProductController@getCheckout',
    'as' => 'checkout',
    'middleware' => 'auth'
]);

Route::post('/checkout', [
    'uses' => 'ProductController@postCheckout',
    'as' => 'checkout',
    'middleware' => 'auth'
]);

Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/signup', [
            'uses' => 'UserController@getSignup',
            'as' => 'user.signup'
        ]);

        Route::post('/signup', [
            'uses' => 'UserController@postSignup',
            'as' => 'user.signup'
        ]);

        Route::get('/signin', [
            'uses' => 'UserController@getSignin',
            'as' => 'user.signin'
        ]);

        Route::post('/signin', [
            'uses' => 'UserController@postSignin',
            'as' => 'user.signin'
        ]);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [
            'uses' => 'UserController@getProfile',
            'as' => 'user.profile'
        ]);

        Route::get('/logout', [
            'uses' => 'UserController@getLogout',
            'as' => 'user.logout'
        ]);
    });
});

Route::group(['prefix' => 'api'], function () {

    Route::get('/cart', [
        'uses' => 'ProductController@getCart',
        'as' => 'product.get'
    ]);
    Route::post('/cart/{id}', [
        'uses' => 'ProductController@postItem',
        'as' => 'product.add'
    ]);
    Route::put('/cart/{id}', [
        'uses' => 'ProductController@putItem',
        'as' => 'product.put'
    ]);
    Route::delete('/cart/{id}', [
        'uses' => 'ProductController@deleteItem',
        'as' => 'product.delete'
    ]);

});


Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'UserController@confirm'
]);

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/item/{id}', [
            'uses' => 'ItemController@getItem',
            'as' => 'item.get'
        ]);

        Route::get('/item', [
            'uses' => 'ItemController@getNewItem',
            'as' => 'item.getnew'
        ]);

        Route::post('/item', [
            'uses' => 'ItemController@postItem',
            'as' => 'item.add'
        ]);

        Route::put('/item/{id}', [
            'uses' => 'ItemController@putItem',
            'as' => 'item.redact'
        ]);

        Route::delete('/item/{id}', [
            'uses' => 'ItemController@deleteItem',
            'as' => 'item.delete'
        ]);
    });
});