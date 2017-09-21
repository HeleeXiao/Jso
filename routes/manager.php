<?php

Route::group(['prefix'=>'manager','namespace'=>'Manager'],function (){
    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('manager.login');
    Route::post('login', 'Auth\LoginController@login')->name('manager.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('manager.logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('manager.register');
    Route::post('register', 'Auth\RegisterController@register')->name('manager.register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('manager.password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('manager.password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('manager.password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('manager.password.reset');

    Route::get('/','IndexController@index')->name("manager.index")->middleware('manager.auth');

    /**
    |--------------------------------------------------------------------------
    |  Roles  Permissions : 权限 角色管理员
    |--------------------------------------------------------------------------
     */
    Route::resource("users","AdministratorController");
    Route::resource("permissions","PermissionController");
    Route::resource("roles","RoleController");
    /**
    |--------------------------------------------------------------------------
    |  Roles  ad : 帖子管理
    |--------------------------------------------------------------------------
     */
    Route::get('ad','AdController@index')->name('manager.ad.list');
    Route::get('ad/{id}','AdController@info')->name('manager.ad.info');
    Route::post('ad/s/{id}','AdController@setStatus')->name('manager.ad.setStatus');
    /**
    |--------------------------------------------------------------------------
    |  Roles  users : 前台用户
    |--------------------------------------------------------------------------
     */

    Route::get('us','UserController@index')->name('manager.us.index');
    Route::post('us/st/{id}','UserController@setType')->name('manager.us.setType');
    Route::post('us/ss/{id}','UserController@setStatus')->name('manager.us.setStatus');

});

