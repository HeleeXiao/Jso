<?php

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

Route::group(['namespace' => 'Web', 'prefix' => '/'], function () {
    Route::get('/', 'IndexController@index')->name('web.home');
    Route::get('captcha', function () {
        return captcha_src();
    })->name('web.captcha');

    Route::group(['middleware' => 'web.auth'], function () {
        Route::get('logout', 'AuthController@logout')->name('web.logout');
        Route::get('account/profile', 'AccountController@profile')->name('web.account.profile');
        Route::get('account/bind-account', 'AccountController@bindAccount')
            ->name('web.account.bind-account');
        Route::get('account/authenticate', 'AccountController@authenticate')
            ->name('web.account.authenticate');
        Route::post('account/postImage', 'AccountController@postImage')->name('web.account.post.image');
        Route::get('account/password/modify', 'AccountController@showPasswordModifyForm')
            ->name('web.password.modify.form');
        Route::post('account/password/postModify', 'AccountController@postModifyPassword')
            ->name('web.password.post.modify');
    });

    Route::group(['middleware' => 'web.guest'], function () {
        Route::get('login', 'AuthController@login')->name('web.login');
        Route::post('postLogin', 'AuthController@postLogin')->name('web.post.login');
        route::get('register', 'AuthController@register')->name('web.register');
        Route::post('postRegister', 'AuthController@postRegister')->name('web.post.register');
        Route::get('password/forget', 'AuthController@showForgetForm')->name('web.password.forget.form');
        Route::post('password/send-reset-mail', 'AuthController@sendResetMail')
            ->name('web.password.post.send.mail');
        Route::get('password/reset/mail-tips/{token}', 'AuthController@showResetMailTips')
            ->name('web.password.reset.mail.tips');
        Route::get('password/reset/{token}', 'AuthController@showResetForm')->name('web.password.reset.form');
        Route::post('password/postReset', 'AuthController@postResetPassword')->name('web.password.post.reset');
    });

//    ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓GLQ维护↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    Route::group(['prefix' => 'ad'], function () {
        Route::get('index', 'AdController@index')->name('web.ad.index');//招聘信息列表
        Route::get('create', 'AdController@create')->name('web.ad.create');//招聘信息发布页
        Route::post('store', 'AdController@store')->name('web.ad.store');//招聘信息发布
        Route::get('show/{id}', 'AdController@show')->name('web.ad.show');//招聘信息详情页
        Route::get('edit/{id}', 'AdController@edit')->name('web.ad.edit');//招聘信息编辑页
        Route::post('update', 'AdController@update')->name('web.ad.update');//招聘信息修改
        Route::get('destroy/{id}', 'AdController@destroy')->name('web.ad.destroy');//招聘信息删除
    });
});

Route::group(['namespace' => 'Tools', 'prefix' => '/'], function () {
    Route::get('/get_area', 'IndexController@get_area')->name('web.get_area');
    Route::get('/get_city', 'IndexController@get_city')->name('web.get_city');
    Route::get('/get_part', 'IndexController@get_part')->name('web.get_part');
});


//    ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑GLQ维护↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

Route::get('/home', 'HomeController@index')->name('home');

