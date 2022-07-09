<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebsiteController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ServiceGroupsController;
use App\Http\Controllers\User\ServiceController;
use App\Http\Controllers\User\ServiceFormController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\CustomerController;

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

Route::get('/sms', [App\Http\Controllers\Web\WebsiteController::class, 'smstest'])->name('w.smstest');


Route::get('/', [App\Http\Controllers\Web\WebsiteController::class, 'index'])->name('w.index');
Route::get('/email', [App\Http\Controllers\Web\WebsiteController::class, 'email']);
Route::get('/about', [App\Http\Controllers\Web\WebsiteController::class, 'about'])->name('w.about');
Route::group(['prefix' => 'categories'], function () {
    Route::get('/service/{id}', [WebsiteController::class, 'single_service'])->name('w.s.service');
    Route::post('/service/send', [WebsiteController::class, 'post_service'])->name('w.s.service.send');
    Route::get('/category/{id}', [WebsiteController::class, 'single_category'])->name('w.s.category');
    Route::get('/pay/form', [WebsiteController::class, 'payform'])->name('w.f.payform');
    Route::post('/payment', [WebsiteController::class, 'post_Pay'])->name('w.f.payment');
});


/** user */
Route::group(['prefix' => 'users'], function () {
    Route::get('/home', [App\Http\Controllers\Web\UserController::class, 'orders'])->name('w.u.orders');
    Route::get('/access', [App\Http\Controllers\Web\UserController::class, 'login'])->name('w.u.login');
    Route::post('/post/access', [App\Http\Controllers\Web\UserController::class, 'post_login'])->name('w.u.post_login');
    Route::get('/logout/app', [App\Http\Controllers\Web\UserController::class, 'logout'])->name('w.u.logout');
});

/** Admin */
Route::group(['prefix' => 'easy/admin'], function () {
    Route::get('/', [UserController::class, 'index'])->name('e.tax.index');
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'users'])->name('e.tax.users');
        Route::post('/add', [UserController::class, 'add_user'])->name('e.tax.add.user');
        Route::get('/view/{id}', [UserController::class, 'view_user'])->name('e.tax.view.user');
        Route::post('/update', [UserController::class, 'update_user'])->name('e.tax.update.user');
        Route::get('/enable/{id}', [UserController::class, 'enable_user'])->name('e.tax.enable.user');
        Route::get('/disable/{id}', [UserController::class, 'disable_user'])->name('e.tax.disable.user');
        Route::get('/stream/{file}', [UserController::class, 'stream'])->name('f.stream');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController::class, 'orders'])->name('e.tax.orders');
        Route::get('/details/{id}', [OrderController::class, 'order'])->name('e.tax.order');
        Route::post('/assign', [OrderController::class, 'assign_order'])->name('f.assign_order');
        Route::post('/upd/status', [OrderController::class, 'update_status'])->name('f.update_status');
        Route::post('/add/bill', [OrderController::class, 'add_bill'])->name('f.add_bill');
    });

    Route::group(['prefix' => 'groups'], function () {
        Route::post('/add', [ServiceGroupsController::class, 'add'])->name('e.tax.add.group');
        Route::get('/view/{id}', [ServiceGroupsController::class, 'view'])->name('e.tax.view.group');
        Route::post('/edit/{id}', [ServiceGroupsController::class, 'edit'])->name('e.tax.edit.group');
        Route::get('/enable/{id}', [ServiceGroupsController::class, 'enable'])->name('e.tax.enable.grp');
        Route::get('/disable/{id}', [ServiceGroupsController::class, 'disable'])->name('e.tax.disable.grp');
    });

    Route::group(['prefix' => 'services'], function () {
        Route::get('/', [ServiceController::class, 'services'])->name('e.tax.services');
        Route::post('/add', [ServiceController::class, 'add'])->name('e.tax.add.service');
        Route::get('/view/{id}', [ServiceController::class, 'view'])->name('e.tax.view.service');
        Route::post('/edit/{id}', [ServiceController::class, 'edit'])->name('e.tax.edit.service');
        Route::get('/enable/{id}', [ServiceController::class, 'enable'])->name('e.tax.enable.svc');
        Route::get('/disable/{id}', [ServiceController::class, 'disable'])->name('e.tax.disable.svc');
    });

    Route::group(['prefix' => 'forms'], function () {
        Route::post('/add', [ServiceFormController::class, 'add'])->name('e.tax.add.form');
        Route::get('/view/{id}', [ServiceFormController::class, 'view'])->name('e.tax.view.form');
        Route::post('/edit/{id}', [ServiceFormController::class, 'edit'])->name('e.tax.edit.form');
        Route::get('/drop/{id}', [ServiceFormController::class, 'drop'])->name('e.tax.drop.form');
    });

    Route::group(['prefix' => 'payments'], function () {
        Route::get('/', [PaymentController::class, 'payments'])->name('e.tax.payments');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [SettingController::class, 'settings'])->name('e.tax.settings');
        Route::post('/update', [SettingController::class, 'update'])->name('e.tax.update.settings');
    });

    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [CustomerController::class, 'customers'])->name('e.tax.customers');
    });

    Route::get('/log/out', [UserController::class, 'exit'])->name('app.exit');
});


Route::group(['prefix' => 'callbacks'], function () {
    Route::post('/pay/status', [WebsiteController::class, 'checkStatus'])->name('w.f.checkStatus');
    Route::any('/payment', [WebsiteController::class, 'callback'])->name('mpesa.callback');
});


Auth::routes(['except' => 'register']);
