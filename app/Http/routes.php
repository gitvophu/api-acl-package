<?php
use Illuminate\Session\TokenMismatchException;

/*
|--------------------------------------------------------------------------
| Public side (no auth required)
|--------------------------------------------------------------------------
|
 */

/**
 * User login and logout
 */
Route::group(['middleware' => ['web']], function () {

    Route::get('/admin/login', [
        "as" => "user.admin.login",
        "uses" => 'LaravelAcl\Authentication\Controllers\AuthController@getAdminLogin',
    ]);
    Route::get('/login', [
        "as" => "user.login",
        "uses" => 'LaravelAcl\Authentication\Controllers\AuthController@getClientLogin',
    ]);
    Route::get('/user/logout', [
        "as" => "user.logout",
        "uses" => 'LaravelAcl\Authentication\Controllers\AuthController@getLogout',
    ]);
    Route::post('/user/login', [
        "uses" => 'LaravelAcl\Authentication\Controllers\AuthController@postAdminLogin',
        "as" => "user.login.process",
    ]);
    Route::post('/login', [
        "uses" => 'LaravelAcl\Authentication\Controllers\AuthController@postClientLogin',
        "as" => "user.login",
    ]);

    /**
     * Password recovery
     */
    Route::get('/user/change-password', [
        "as" => "user.change-password",
        "uses" => 'LaravelAcl\Authentication\Controllers\AuthController@getChangePassword',
    ]);
    Route::get('/user/recovery-password', [
        "as" => "user.recovery-password",
        "uses" => 'LaravelAcl\Authentication\Controllers\AuthController@getReminder',
    ]);
    Route::post('/user/change-password/', [
        'uses' => 'LaravelAcl\Authentication\Controllers\AuthController@postChangePassword',
        "as" => "user.reminder.process",
    ]);

    Route::get('/user/change-password-success', [
        "uses" => function () {
            return view('laravel-authentication-acl::client.auth.change-password-success');
        },
        "as" => "user.change-password-success",
    ]
    );
    Route::post('/user/reminder', [
        'uses' => 'LaravelAcl\Authentication\Controllers\AuthController@postReminder',
        "as" => "user.reminder",
    ]);
    Route::get('/user/reminder-success', [
        "uses" => function () {
            return view('laravel-authentication-acl::client.auth.reminder-success');
        },
        "as" => "user.reminder-success",
    ]);

    /**
     * User signup
     */
    Route::post('/user/signup', [
        'uses' => 'LaravelAcl\Authentication\Controllers\UserController@postSignup',
        "as" => "user.signup.process",
    ]);
    Route::get('/user/signup', [
        'uses' => 'LaravelAcl\Authentication\Controllers\UserController@signup',
        "as" => "user.signup",
    ]);
    Route::post('captcha-ajax', [
        "before" => "captcha-ajax",
        'uses' => 'LaravelAcl\Authentication\Controllers\UserController@refreshCaptcha',
        "as" => "user.captcha-ajax.process",
    ]);
    Route::get('/user/email-confirmation', [
        'uses' => 'LaravelAcl\Authentication\Controllers\UserController@emailConfirmation',
        "as" => "user.email-confirmation",
    ]);
    Route::get('/user/signup-success', [
        "uses" => 'LaravelAcl\Authentication\Controllers\UserController@signupSuccess',
        "as" => "user.signup-success",
    ]);

    /*
    |--------------------------------------------------------------------------
    | Admin side (auth required)
    |--------------------------------------------------------------------------
    |
     */
    Route::group(['middleware' => ['admin_logged',/* 'can_see' */]], function () {
        /**
         * dashboard
         */
        Route::get('/admin/users/dashboard', [
            'as' => 'dashboard.default',
            'uses' => 'LaravelAcl\Authentication\Controllers\DashboardController@base',
        ]);

/**
         * product
         */
        Route::get('/admin/products/list', [
            'as' => 'products.list',
            'uses' => 'LaravelAcl\Authentication\Controllers\ProductController@getList',
        ]);
        Route::get('/admin/products/edit/{id}', [
            'as' => 'products.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\ProductController@editProduct',
        ]);
        Route::get('/admin/products/create', [
            'as' => 'products.create',
            'uses' => 'LaravelAcl\Authentication\Controllers\ProductController@createProduct',
        ]);
        Route::post('/admin/products/store', [
            'as' => 'products.store',
            'uses' => 'LaravelAcl\Authentication\Controllers\ProductController@storeProduct',
        ]);
        Route::post('/admin/products', [
            'as' => 'products.update',
            'uses' => 'LaravelAcl\Authentication\Controllers\ProductController@updateProduct',
        ]);
        Route::get('/admin/products/delete/{id}', [
            'as' => 'products.delete',
            'uses' => 'LaravelAcl\Authentication\Controllers\ProductController@deleteProduct',
        ]);
        /**
         * user
         */
        Route::get('/admin/users/list', [
            'as' => 'users.list',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@getList',
        ]);
        Route::get('/admin/users/edit', [
            'as' => 'users.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@editUser',
        ]);
        Route::post('/admin/users/edit', [
            'as' => 'users.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@postEditUser',
        ]);
        Route::get('/admin/users/delete', [
            'as' => 'users.delete',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@deleteUser',
        ]);
        Route::post('/admin/users/groups/add', [
            'as' => 'users.groups.add',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@addGroup',
        ]);
        Route::post('/admin/users/groups/delete', [
            'as' => 'users.groups.delete',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@deleteGroup',
        ]);
        Route::post('/admin/users/editpermission', [
            'as' => 'users.edit.permission',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@editPermission',
        ]);
        Route::get('/admin/users/profile/edit', [
            'as' => 'users.profile.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@editProfile',
        ]);
        Route::post('/admin/users/profile/edit', [
            'as' => 'users.profile.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@postEditProfile',
        ]);
        Route::post('/admin/users/profile/addField', [
            'as' => 'users.profile.addfield',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@addCustomFieldType',
        ]);
        Route::post('/admin/users/profile/deleteField', [
            'as' => 'users.profile.deletefield',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@deleteCustomFieldType',
        ]);
        Route::post('/admin/users/profile/avatar', [
            'as' => 'users.profile.changeavatar',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@changeAvatar',
        ]);
        Route::get('/admin/users/profile/self', [
            'as' => 'users.selfprofile.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\UserController@editOwnProfile',
        ]);

        /**
         * groups
         */
        Route::get('/admin/groups/list', [
            'as' => 'groups.list',
            'uses' => 'LaravelAcl\Authentication\Controllers\GroupController@getList',
        ]);
        Route::get('/admin/groups/edit', [
            'as' => 'groups.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\GroupController@editGroup',
        ]);
        Route::post('/admin/groups/edit', [
            'as' => 'groups.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\GroupController@postEditGroup',
        ]);
        Route::get('/admin/groups/delete', [
            'as' => 'groups.delete',
            'uses' => 'LaravelAcl\Authentication\Controllers\GroupController@deleteGroup',
        ]);
        Route::post('/admin/groups/editpermission', [
            'as' => 'groups.edit.permission',
            'uses' => 'LaravelAcl\Authentication\Controllers\GroupController@editPermission',
        ]);

        /**
         * permissions
         */
        Route::get('/admin/permissions/list', [
            'as' => 'permission.list',
            'uses' => 'LaravelAcl\Authentication\Controllers\PermissionController@getList',
        ]);
        Route::get('/admin/permissions/edit', [
            'as' => 'permission.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\PermissionController@editPermission',
        ]);
        Route::post('/admin/permissions/edit', [
            'as' => 'permission.edit',
            'uses' => 'LaravelAcl\Authentication\Controllers\PermissionController@postEditPermission',
        ]);
        Route::get('/admin/permissions/delete', [
            'as' => 'permission.delete',
            'uses' => 'LaravelAcl\Authentication\Controllers\PermissionController@deletePermission',
        ]);
    });
});
//////////////////// Automatic error handling //////////////////////////

if (Config::get('acl_base.handle_errors')) {
    App::error(function (RuntimeException $exception, $code) {
        switch ($code) {
            case '404':
                return view('laravel-authentication-acl::client.exceptions.404');
                break;
            case '401':
                return view('laravel-authentication-acl::client.exceptions.401');
                break;
            case '500':
                return view('laravel-authentication-acl::client.exceptions.500');
                break;
        }
    });

    App::error(function (TokenMismatchException $exception) {
        return view('laravel-authentication-acl::client.exceptions.500');
    });
}

Route::group(['prefix' => 'api', 'namespace' => 'LaravelAcl\Authentication\Controllers'], function () {

    Route::get('/users', 'ApiUserController@index')->name('showalluser');
    Route::post('/users/page', 'ApiUserController@paging')->name('paging');
    Route::get('/users/search', 'ApiUserController@search')->name('search');
    Route::get('/users/{id}', 'ApiUserController@showUser')->name('showauser');
    Route::post('/users/login', 'ApiUserController@loginUser')->name('loginUser');
    Route::post('/users/logout', 'ApiUserController@logoutUser')->name('logoutUser');
    Route::post('/users/create', 'ApiUserController@createUser')->name('createUser');
    Route::put('/users/update/{id}', 'ApiUserController@updateUser')->name('updateuser');
    Route::put('/users/change-password/{id}', 'ApiUserController@changeUserPassword')->name('change-password');
    Route::delete('/users/delete/{id}', 'ApiUserController@deleteUser')->name('deleteuser');

    Route::group(['prefix' => 'users'], function () {
        Route::post('/update-with-image', 'ApiUserController@updateWithImage');
        Route::post('/sendMail', 'ApiUserController@phuSendMail');
    });

//product

    Route::get('/products', 'ProductController@index')->name('index');
    Route::post('/products/page', 'ProductController@paging')->name('paging');
    Route::get('/products/{id}', 'ProductController@showProduct')->name('showProduct');
    Route::post('/products/create', 'ProductController@createProduct')->name('createProduct');
    Route::put('/products/update/{id}', 'ProductController@updateProduct')->name('updateProduct');
    Route::delete('/products/delete/{id}', 'ProductController@deleteProduct')->name('deleteProduct');

//images

    Route::group(['prefix' => 'images'], function () {
        Route::post('/', 'ImageController@store');
        Route::delete('/delete/{id}', 'ImageController@delete');
        Route::post('/update', 'ImageController@update_image');
    });

//user type

    Route::group(['prefix' => 'user_type'], function () {
        Route::get('/', 'UserTypeController@index');
        Route::post('/create', 'UserTypeController@create');
        Route::put('/update/{id}', 'UserTypeController@edit');
        Route::delete('/delete/{id}', 'UserTypeController@destroy');
    });

});
